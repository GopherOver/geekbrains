<?php

namespace app;


class Application
{
    use Singleton;

    public $router;
    public $config = [];

    public function start()
    {
        $this->config = getConfig();
        $this->router = new Router();
        $this->router ->run();
    }
}