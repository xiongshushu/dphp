<?php

class di
{
    private static $services = array();

    static function register($name, $call)
    {
        self::$services[$name] = !is_callable($call) ? new $call() : $call();
    }

    static function invoke($name, $service = "")
    {
        if (!isset(self::$services[$name])) {
            self::$services[$name] = new $service;
        }
        return self::$services[$name];
    }
}