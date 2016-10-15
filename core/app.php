<?php

use http\response;
use http\router;

class app
{
    private static $container = array();

    static function join($name, $call)
    {
        self::$container[$name] = !is_callable($call) ? new $call() : $call();
    }

    static function in($name, $service = "")
    {
        if (!isset(self::$container[$name])) {
            self::$container[$name] = new $service;
        }
        return self::$container[$name];
    }

    static function mysql($config)
    {
        self::join("db", function () use ($config) {
            return new \db\pdo($config);
        });
    }

    static function route($rule)
    {
        router::set($rule);
    }

    static function init()
    {
        //基本常量
        define("DP_VER", "1.0.0 Beta", false);
        defined("CORE_PATH") OR define("CORE_PATH", __DIR__);
        defined("APP_PATH") OR define("APP_PATH", dirname(CORE_PATH));
        defined("ROOT_PATH") OR define("ROOT_PATH", dirname(APP_PATH));
        defined("LOG_PATH") OR define("LOG_PATH", ROOT_PATH . "/logs/");

        /**
         * 实例化模型
         * @param $table
         * @param $module
         * @return \model
         */
        function M($table, $module = _MODULE_)
        {
            return P("models\\" . $table, $module);
        }

        /**
         * 调用模块的逻辑层
         * @param $module
         * @return object
         */
        function L($module = _MODULE_)
        {
            return app::in($module . "_logic", $module . "\\libs\\logic");
        }

        /**
         * 调用模块通用包
         * @param string $lib
         * @param string $module
         * @return mixed
         */
        function P($lib, $module = _MODULE_)
        {
            return app::in($module . "_" . $lib, $module . "\\libs\\" . $lib);
        }

        /**
         * 加载返回格式为数组的php配置文件
         * @param $config
         * @param $item
         * @return mixed
         */
        function C($config, $item = "")
        {
            static $_config = array();
            if (!isset($_config[$config])) {
                $conf = explode(".", $config);
                $_config[$config] = include APP_PATH . "/" . (count($conf) > 1 ? $conf[0] . "/config/" . $conf[1] : "config/" . $conf[0]) . ".php";
            }
            return empty($item) ? $_config[$config] : $_config[$config][$item];
        }

        //autoload
        spl_autoload_register(function ($className) {
            $class = "/" . str_replace("\\", "/", $className) . ".php";
            $load = function ($class, array $loadDir) {
                foreach ($loadDir as $dir) {
                    if (file_exists($dir . $class)) {
                        return require_once $dir . $class;
                    }
                }
            };
            $load($class, array(CORE_PATH, APP_PATH, ROOT_PATH));
        });
    }

    static function run()
    {
        try {
            router::parseUrl();
            define("_SUB_", router::$child);
            define("_MODULE_", router::$module);
            define("_ACTION_", router::$action);
            define("_CONTROLLER_", router::$controller);
            define("MOD_PATH", APP_PATH . "/" . _MODULE_);
            $class = _MODULE_ . "\\" . (_SUB_ == "" ? "" : _SUB_ . "\\") . _CONTROLLER_;
            if (class_exists($class))
                return (new $class())->{_ACTION_}();
            error::panic("Cannot load the file:$class.php");
        } catch (\Exception $e) {
            response::error($e->getMessage());
        }
    }
}