<?php
namespace Du;

use Du\DI\Injectable;

class DI extends Injectable
{

    /**
     * 默认DI容器
     * @var \Du\DI
     */
    static $di;

    public $services = array();

    public $alias = array(
        "form" => "\\Du\\Form\\Form",
        "request" => "\\Du\\Http\\Request",
        "response" => "\\Du\\Http\\Response",
        "router" => "\\Du\\Http\\Router",
        "session" => "\\Du\\Storage\\Session",
        "cookie" => "\\Du\\Storage\\Cookie",
        "log" => "\\Du\\Storage\\Log",
        "upload" => "\\Du\\Storage\\Upload",
        "captcha" => "\\Du\\Verify\\Captcha",
        "dispatcher" => "\\Du\\Http\\Dispatcher",
        "page" => "\\Du\\Model\\Page",
        "config" => "\\Du\\Config",
        "view" => "\\Du\\View",
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