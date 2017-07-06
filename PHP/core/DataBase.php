<?php

namespace core;


use PDO,
    PHPUnit\Runner\Exception;

class DataBase
{
    private $pdo;

    function __construct(string $connection = 'default')
    {
        try {
            $config     = Application::instance()->config['db'][$connection];
            $dbHost     = $config['host'];
            $dbName     = $config['name'];
            $dbCharset  = $config['charset'];
            $dbUser     = $config['user'];
            $dbPass     = $config['pass'];

            $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName . ";charset=" . $dbCharset;

            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=""'
            ];

            $this->pdo = new PDO($dsn, $dbUser, $dbPass, $opt);
        } catch (Exception $e) {
            echo "Can't connect to database";
        }

    }

    public function execute(string $query, array $props, bool $fetchAll = false)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($props);
            $result = $fetchAll ? $stmt->fetchAll() : $stmt->fetch();
        } catch (\Exception $e) {
            die($e);
        }

        return $result ? $result : false;
    }
}