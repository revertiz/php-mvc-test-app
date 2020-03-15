<?php


namespace Kodas\Core;


class Application
{
    protected $controller = 'HomeController';
    protected $action = 'index';
    protected $parameters = [];


    public function __construct()
    {
        $this->prepareURL();
        if (file_exists(CONTROLLER . $this->controller . '.php')) {
            $this->controller = '\Kodas\Controller\\' . $this->controller;
            $this->controller = new $this->controller;
            if(method_exists($this->controller, $this->action)){
                call_user_func_array([$this->controller,$this->action],$this->parameters);
            };
        }
    }

    protected function prepareURL()
    {
        $request = parse_url($_SERVER['REQUEST_URI']);
        $request = ltrim($request['path'], '/');
        if (!empty($request)) {
            $url = explode('/', $request);
            $this->controller = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
            $this->action = isset($url[1]) ? $url[1] : 'index';
        }
    }
}
