<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/31/20
 * Time: 10:06 PM
 */

class sessionController
{
    public function add_session($sessions = array())
    {
        if (!isset($_SESSION)){
            session_start();
        }
        foreach ($sessions as $name => $value){
            $_SESSION[$name] = $value;
        }
    }

    public function check_session($name)
    {
        if (!isset($_SESSION)){
            session_start();
        }
        if (isset($_SESSION) && isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return false;
    }
}