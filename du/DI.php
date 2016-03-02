<?php
namespace du;

use du\di\Injectable;

class DI extends Injectable
{

    /**
     * 默认DI容器
     * @var \Du\DI
     */
    static $di;

    public $services = array();

    public $alias = array(
        "form" => "\\du\\form\\Form",
        "request" => "\\du\\http\\Request",
        "response" => "\\du\\http\\Response",
        "router" => "\\du\\http\\Router",
        "session" => "\\du\\http\\Session",
        "cookie" => "\\du\\http\\Cookie",
        "log" => "\\du\\storage\\Log",
        "upload" => "\\du\\storage\\Upload",
        "captcha" => "\\du\\verify\\Captcha",
        "dispatcher" => "\\du\\http\\Dispatcher",
        "page" => "\\du\\pagination\\Page",
        "config" => "\\du\\config",
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