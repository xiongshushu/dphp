<?php
namespace Du;

class DI extends Service
{

    /**
     * 默认DI容器
     * @var \Du\DI
     */
    static $di;

    public function __construct()
    {
        parent::__construct();
        if (! self::$di) {
            self::$di = $this;
        }
    }

    /**
     * 获取DI实例
     * @return \Du\DI
     */
    public function getDI()
    {
        return $this;
    }

    public function register($name, $call)
    {
        $this->$name = !is_callable($call)?new $call():$call();
    }

    static function invoke($name)
    {
        if (strrchr($name,"Model")) {
            $model = __MODULE__."\\Models\\".$name;
            if (!isset(self::$di->models[$model]))
            {
                self::$di->models[$model] = new $model;
            }
            return self::$di->models[$model];
        }
        return self::$di->$name;
    }
}