<?php

class App
{
    protected $controller;
    protected $controllerName;
    protected $method;
    protected $params = [];

    public function __construct()
    {
        $this->controller = Config::get('app/default_controller');
        $this->controllerName = Config::get('app/default_controller');
        $this->method = Config::get('app/default_method');

        $url = $this->parseUrl();

        if ($url && file_exists(Config::get('url/inc_root') . '/app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            $this->controllerName = $url[0];
            unset($url[0]);
        }

        $GLOBALS['page'] = $this->controllerName;
        require_once Config::get('url/inc_root') . '/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
    }

    public function getController()
    {
        return $this->controllerName;
    }
}
