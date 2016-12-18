<?php

use http\router;
use http\session;

class app
{
    private static $container = array();

    public static $config = array();

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

    static function init()
    {
        define("DP_VER", "1.0.1", false);
        defined("CORE_PATH") OR define("CORE_PATH", __DIR__);
        defined("ROOT_PATH") OR define("ROOT_PATH", dirname(CORE_PATH));
        defined("PLUGIN_PATH") OR define("PLUGIN_PATH", ROOT_PATH . "/plugins");
        defined("APP_PATH") OR define("APP_PATH", ROOT_PATH . "/app");
        defined("LOG_PATH") OR define("LOG_PATH", ROOT_PATH . "/logs");

        function L($module = _MODULE_)
        {
            return app::in($module . "Logic", $module . "\\libs\\" . $module);
        }

        function P($lib, $module = _MODULE_)
        {
            return app::in($module . "_" . $lib, $module . "\\libs\\" . $lib);
        }

        function C($key, $item = "")
        {
            if (!isset(app::$config[$key])) {
                $split = explode(".", $key);
                $dest = count($split) > 1 ? $split[0] . "/config/" . $split[1] : "config/" . $split[0];
                app::$config[$key] = include APP_PATH . "/$dest.php";
            }
            return empty($item) ? app::$config[$key] : app::$config[$key][$item];
        }

        //autoload
        spl_autoload_register(function ($className) {
            $class = "/" . str_replace("\\", "/", $className) . ".php";
            self::autoLoad($class, array(CORE_PATH, APP_PATH, ROOT_PATH));
        });

        plugin::init();
        session::start();
        self::$config = include ROOT_PATH . "/config/app.php";
        empty(self::$config['db']) || db::connect(self::$config['db']);
        empty(self::$config['rule']) || router::set(self::$config['rule']);
    }

    static function autoLoad($class, array $loadDir)
    {
        foreach ($loadDir as $dir) {
            if (file_exists($dir . $class)) {
                return require_once "$dir$class";
            }
        }
    }

    static function run()
    {
        try {
            router::parseUrl();
            define("_LAYER_", router::$child);
            define("_MODULE_", router::$module);
            define("_ACTION_", router::$action);
            define("_CONTROLLER_", router::$controller);
            define("MOD_PATH", APP_PATH . "/" . _MODULE_);
            $class = _MODULE_ . "\\" . (_LAYER_ == "" ? "" : _LAYER_ . "\\") . _CONTROLLER_;
            if (class_exists($class))
                return (new $class())->{_ACTION_}();
            http::error(404, "Can't load the file:$class.php");
        } catch (\Exception $e) {
            errors::panic($e->getMessage());
        }
    }
}