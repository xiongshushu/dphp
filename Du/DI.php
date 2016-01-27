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

    public function registe($name, $call)
    {
        if (! is_callable($call)) {
            $this->$name = new $call();
        } else {
            $this->$name = $call();
        }
    }
}