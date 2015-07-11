<?php
namespace Du;

class Session
{

    public function set($name, $value=null)
    {
        $_SESSION[$name]=$value;
    }

    public function start()
    {
        if (session_status()!=2)
        {
            session_start();
        }
    }

    public function clear($key)
    {
        unset($_SESSION[$key]);
    }

    public function get($name)
    {
        return isset($_SESSION[$name])?$_SESSION[$name]:null;
    }

    public function destroy()
    {
        session_destroy();
    }
}