<?php

class Dispatcher
{

    private $request;

    public function dispatch()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        if ($this->request->valid){
            $controller = $this->loadController();
            if ($controller && method_exists($controller, $this->request->action)){
                call_user_func_array([$controller, $this->request->action], $this->request->params);
            }else{
                echo 404;
            }
        }
    }

    public function loadController()
    {
        $name = $this->request->controller . "Controller";
        $file = ROOT . 'Controllers/' . $name . '.php';
        if (!file_exists($file)){
            echo "404";
            return false;
        }
        require($file);
        $controller = new $name();
        return $controller;
    }

}
?>