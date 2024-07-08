<?php

class Router
{
    static public function parse($url, $request)
    {
        $url = trim($url);
        $url_pars = explode("/",$url);
        array_shift($url_pars);
        $explode_url = explode('/', $url);
        $explode_url = array_slice($explode_url, 1);
        $request->valid = true;
        if ($url == "/") {
            $request->controller = "public";
            $request->action = "mainpage";
            $request->params = [];
        } elseif ($url == "/add-plan"){
            $request->controller = "public";
            $request->action = "add_plan";
            $request->params = [];
        } elseif ($url == "/admin/login"){
            $request->controller = "public";
            $request->action = "login";
            $request->params = ["admin", "login"];
        } elseif ($url == "/judge/login"){
            $request->controller = "public";
            $request->action = "login";
            $request->params = ["judge", "login"];
        } elseif ($url == "/logout"){
            session_start();
            if (isset($_SESSION)){
                unset($_SESSION);
            }
            session_destroy();
            header("location: /");
        }elseif ($url == "/tracking"){
            $request->controller = "public";
            $request->action = "tracking";
            $request->params = [];
        } else {
            $request->controller = $explode_url[0];
            if(isset($explode_url[1])){
                $request->action = $explode_url[1];
            }else{
                $request->action = "";
            }
            $request->params = array_slice($explode_url, 2);
        }

    }
}
?>