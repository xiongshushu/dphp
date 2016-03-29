<?php
namespace http;

class cookie
{

    static function set($key, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        setcookie($key, $value, $expire, $path, $domain, $secure, $httponly);
    }

    static function get($key)
    {
        return isset( $_COOKIE[$key] ) ? $_COOKIE[$key] : null;
    }

    static function remove($key)
    {
        unset( $_COOKIE[$key] );
    }

    static function destroy()
    {
        unset( $_COOKIE );
    }
}