<?php

class dm
{
    private static $container = array();

    static function join($name, $call)
    {
        self::$container[$name] = !is_callable($call) ? new $call() : $call();
    }

    static function in($name, $service = "")
    {
        if (!isset(self::$container[$name])) {
            self::$container[$name] = new $service;
        }
        return self::$container[$name];
    }
}