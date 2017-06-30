<?php

namespace models;

use app\Application;
use PDO;

class DatabaseModel
{
    protected $_instanceDB;

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

    public function execute($query, $props = [])
    {
        try {
            $stmt = $this->_instanceDB->prepare($query);
            $stmt->execute($props);
            $data = $stmt->fetch();
        } catch (\Exception $e) {
            die($e);
        }

        return $data ? $data : false;
    }

}