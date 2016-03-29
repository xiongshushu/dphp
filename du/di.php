<?php

class di
{
    /**
     * 默认DI容器
     * @var \mode\di
     */
    static $di;

    public $services = array();

    public function __construct()
    {
        if (!self::$di) {
            self::$di = $this;
        }
    }

    public function register($name, $call)
    {
        $this->services[$name] = !is_callable($call) ? new $call() : $call();
    }

    static function invoke($name, $service = "")
    {
        if (!isset(self::$di->services[$name])) {
            self::$di->services[$name] = new $service;
        }
        return self::$di->services[$name];
    }
}