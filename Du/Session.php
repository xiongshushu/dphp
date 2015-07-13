<?php
namespace Du;

class Session
{

    public function set($key, $value=null)
    {
        $_SESSION[$key]=$value;
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

    public function get($key)
    {
        return isset($_SESSION[$key])?$_SESSION[$key]:null;
    }

    public function destroy()
    {
        session_destroy();
    }
}