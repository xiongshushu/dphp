<?php
namespace du;

use du\di\injectable;

class di extends injectable
{

    /**
     * 默认DI容器
     * @var \Du\DI
     */
    static $di;

    public $services = array();

    public $alias = array(
        "form" => "\\du\\form\\form",
        "request" => "\\du\\http\\request",
        "response" => "\\du\\http\\response",
        "router" => "\\du\\http\\router",
        "session" => "\\du\\http\\session",
        "cookie" => "\\du\\http\\cookie",
        "log" => "\\du\\storage\\log",
        "upload" => "\\du\\storage\\upload",
        "captcha" => "\\du\\verify\\captcha",
        "page" => "\\du\\pagination\\page",
        "config" => "\\du\\config",
        "view" => "\\du\\view",
    );

    public function __construct()
    {
        if ( !self::$di )
        {
            self::$di = $this;
        }
    }

    public function register($name, $call)
    {
        $this->services[$name] = !is_callable($call) ? new $call() : $call();
    }

    static function invoke($name)
    {
        if ( !isset( self::$di->services[$name] ) )
        {
            if ( strrchr($name, "Model") )
            {
                $service = MODEL_SPACE . "\\" . $name;
            } else
            {
                $service = self::$di->alias[$name];
            }
            self::$di->services[$name] = new $service;
        }
        return self::$di->services[$name];
    }
}