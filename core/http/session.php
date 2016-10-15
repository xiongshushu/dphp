<?php
namespace http;

class session
{

    static function set($key, $value = null)
    {
        $_SESSION[$key] = $value;
    }

    static function start()
    {
        if (session_status() != 2) {
            session_start();
        }
    }

    static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    static function destroy()
    {
        session_destroy();
    }
}