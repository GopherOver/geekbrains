<?php

namespace core;


class Application
{
    use Singleton;

    public $router;
    public $config = [];

    private $db = null;

    public function start()
    {
        $this->config   = getConfig();
        $this->router   = new Router();

        $this->router->run();
    }

    public function db()
    {
        if (empty($this->db))
            $this->db = new DataBase();

        return $this->db;
    }
}