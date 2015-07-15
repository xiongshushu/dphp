<?php
namespace Du;

class Cookie
{

    public function set($key, $value=null, $expire=null, $path=null, $domain=null, $secure=null, $httponly=null)
    {
        setcookie($key, $value, $expire, $path, $domain, $secure, $httponly);
    }

    public function get($key)
    {
        return isset($_COOKIE[$key])?$_COOKIE[$key]:null;
    }
    
    public function remove($key)
    {
        unset($_COOKIE[$key]);
    }
    public function destroy()
    {
    	unset($_COOKIE);
    }
}