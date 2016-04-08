<?php

class model
{
    private static $driver;

    public function __construct()
    {
        self::$driver = di::invoke("db");
    }

    public function __call($name, $args)
    {
        if (empty(self::$driver)) {
            e::panic("driver missed!");
        }
        if (method_exists(self::$driver, $name)) {
            return call_user_func_array(array(self::$driver, $name), $args);
        }
        return FALSE;
    }

    static function query($sql,$data)
    {
        self::$driver->query($sql,$data);
    }

}