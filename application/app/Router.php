<?php

namespace app;

class Router
{
    private $routes = [];
    private $params = [];

    /**
     * Разделить переданный URL на компоненты
     */
    public function splitUrl($url)
    {
        return preg_split('/\//', $url, -1, PREG_SPLIT_NO_EMPTY);
    }

    private function addRoutes()
    {
        $routes = Application::instance()->config['routes'];
        $this->routes = array_merge($this->routes, $routes);
    }

    public function run($requestedUri = null)
    {
        // Добавляем маршруты
        $this->addRoutes();
        // Если URL не передан, берем его из REQUEST_URI
        if (empty($requestedUri))
        {
            $uri = reset(explode('?', $_SERVER['REQUEST_URI']));
            $requestedUri = urldecode(rtrim($uri, '/'));
        }

        // если URL и маршрут полностью совпадают
        if (isset($this->routes[$requestedUri]))
        {
            $this->params = $this->splitUrl($this->routes[$requestedUri]);
            return $this->executeAction();
        }

        foreach ($this->routes as $route => $uri)
        {
            // Заменяем wildcards на регулярные выражения
            if (strpos($route, ':') !== false)
            {
                $route = str_replace(':any', '(.+)',
                    str_replace(':num', '([0-9]+)',
                        str_replace(':str', '([a-zA-Z]+)',
                        $route))
                );
            }

            if (preg_match('#^'.$route.'$#', $requestedUri))
            {
                if (strpos($uri, '$') !== false && strpos($route, '(') !== false)
                {
                    $uri = preg_replace('#^'.$route.'$#', $uri, $requestedUri);
                }
                $this->params = $this->splitUrl($uri);

                break; // URL обработан!
            }
        }
        return $this->executeAction();
    }

    /**
     * Запуск соответствующего действия/экшена/метода контроллера
     */
    private function executeAction()
    {
        $controller = 'controllers\MainController';
        $action = 'actionIndex';

        if (isset($this->params[0]))
        {
            $controller = 'controllers\\' . ucfirst($this->params[0]) . 'Controller';
        }

        if (isset($this->params[1]))
        {
            $action = 'action' . ucfirst($this->params[1]);
        }

        $params = array_slice($this->params, 2);

        if (empty($params))
            (new $controller())->$action();
        else
            return call_user_func_array([$controller, $action], $params);
    }

    public function redirect($to = '/')
    {
        header("Location: " . $to);
    }
}