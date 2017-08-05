<?php

namespace core;

/**
 * Class Router
 * @package core
 */
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

    /**
     * Добавление роутов
     */
    private function addRoutes()
    {
        $routes = Application::instance()->config['routes'];
        $this->routes = array_merge($this->routes, $routes);
    }

    /**
     * Стартуем роутер
     * @param null $requestedUri
     * @return mixed
     */
    public function run($requestedUri = null)
    {
        // Добавляем маршруты
        $this->addRoutes();
        // Если URL не передан, берем его из REQUEST_URI
        if ($requestedUri === NULL)
        {
            $uri_e = explode('?', $_SERVER['REQUEST_URI']);
            $uri = reset($uri_e);
            $requestedUri = urldecode(rtrim($uri, '/'));
        }

        // если URL и маршрут полностью совпадают
        if (isset($this->routes[$requestedUri]))
        {
            $this->params = $this->splitUrl($this->routes[$requestedUri]);
            $this->params = array_merge($this->params, explode('=', explode('?', $_SERVER['REQUEST_URI'])[1]));
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

        $controller = new $controller();

        if (empty($params))
            $controller->$action();
        else {
            if ($params){
                $params = array_flip($params);

                foreach ($params as $key => $val){
                    $ks = $key;
                    next($params);
                    $params[$ks] = key($params);
                }
                array_pop($params);
            }

            return call_user_func_array([$controller, $action], [$params]);
        }
    }

    public function redirect($to = '/')
    {
        header("Location: " . $to);
    }
}