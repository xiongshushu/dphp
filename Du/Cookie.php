<?php
namespace Du;

class Cookie
{

    public function set($name, $value=null, $expire=null, $path=null, $domain=null, $secure=null, $httponly=null)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    public function get($name)
    {
        return isset($_COOKIE[$name])?$_COOKIE[$name]:null;
    }
    
    public function destroy()
    {
    	unset($_COOKIE);
    }
}