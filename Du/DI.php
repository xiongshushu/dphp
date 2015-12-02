<?php
namespace Du;

class DI
{

    /**
     * DI容器
     * 
     * @var \DU\Application
     */
    static $di;

    /**
     * 加载DI(注意调用一次即可)
     * 
     * @param Service $service            
     */
    static function Load(Application $app)
    {
        self::$di = $app;
    }

    /**
     * 调用DI中的服务
     * 
     * @param string $name            
     */
    static function invoke($name)
    {
        return self::$di->$name;
    }
}