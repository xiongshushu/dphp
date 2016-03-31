<?php

use http\router;
use http\response;

class app
{
    /**
     * 运行
     * @return mixed
     */
    static function run()
    {
        try {
            router::parseUrl();
            define("LAYER",router::$layer);
            define("MODULE",router::$module);
            define("ACTION",router::$action);
            define("CONTROLLER",router::$controller);
            $class = MODULE . "\\" . (LAYER == "" ? "" : LAYER . "\\") . CONTROLLER;
            if (class_exists($class))
                return (new $class())->{ACTION}();
            throw new error("Cannot load the file:$class.php");
        } catch (error $e) {
            response::error($e->getMessage());
        }
    }
}