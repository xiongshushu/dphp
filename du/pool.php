<?php

class pool
{
    private static $pool = array();

    static function join($name, $call)
    {
        self::$pool[$name] = !is_callable($call) ? new $call() : $call();
    }

    static function in($name, $service = "")
    {
        if (!isset(self::$pool[$name])) {
            self::$pool[$name] = new $service;
        }
        return self::$pool[$name];
    }
}