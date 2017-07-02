<?php

namespace models;

use app\Application;
use PDO;

class DatabaseModel
{
    private $_instanceDB;
    protected $_table;

    function __construct()
    {
        $dsn = "mysql:host=" . Application::instance()->config['db']['host'] . ";dbname=" . Application::instance()->config['db']['name'] . ";charset=utf8";

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->_instanceDB = new PDO($dsn, Application::instance()->config['db']['user'], Application::instance()->config['db']['pass'], $opt);
    }

    private function execute($query, $props = [], $fetchAll = false)
    {
        try {
            $stmt = $this->_instanceDB->prepare($query);
            $stmt->execute($props);
            $data = $fetchAll ? $stmt->fetchAll() : $stmt->fetch();
        } catch (\Exception $e) {
            die($e);
        }

        return $data ? $data : false;
    }

    public function findAll($table = NULL, $where = NULL)
    {
        $query = 'SELECT
                *
            FROM ';

        $query .= $table ? $table : $this->_table;

        if (isset($where))
            $query .= '
            WHERE
            '.$where;

        $query .= ' LIMIT 10';

        $props = [];

        return $this->execute($query, $props, true);
    }

    public function findId($id)
    {
        $query = 'SELECT
                *
            FROM '.$this->_table. '
            WHERE
              `id` = :id';

        $props = [
            'id' => $id
        ];

        return $this->execute($query, $props);
    }

}