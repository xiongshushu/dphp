<?php

use http\response;
use http\router;

class lm
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

    static function error($message = "", $code = 0, Exception $previous = null)
    {
        throw new \Exception($message, $code, $previous);
    }

    /**
     * 记录日志
     * @param string $log
     * @param string $destination
     */
    static function log($log, $destination = '')
    {
        if (empty($destination)) {
            $destination = LOG_PATH . date('Y_m_d') . '.log';
        }
        // 自动创建日志目录
        $log_dir = dirname($destination);
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (is_file($destination) && 2048000 <= filesize($destination)) {
            rename($destination, dirname($destination) . '/' . time() . '-' . basename($destination));
        }
        error_log("[" . date("Y-m-d H:i:s") . "] " . $_SERVER["REQUEST_URI"] . "\r\n {$log}\r\n", 3, $destination);
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
            return lm::in($module . ".logic", $module . "\\libs\\logic");
        }

        /**
         * 调用模块通用包
         * @param string $lib
         * @param string $module
         * @return mixed
         */
        function P($lib, $module = _MODULE_)
        {
            return lm::in($module . "." . $lib, $module . "\\libs\\" . $lib);
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

        //自动加载
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
            define("_SUBMOD_", router::$child);
            define("_MODULE_", router::$module);
            define("_ACTION_", router::$action);
            define("_CONTROLLER_", router::$controller);
            $class = _MODULE_ . "\\" . (_SUBMOD_ == "" ? "" : _SUBMOD_ . "\\") . _CONTROLLER_;
            if (class_exists($class))
                return (new $class())->{_ACTION_}();
            self::error("Cannot load the file:$class.php");
        } catch (\Exception $e) {
            response::error($e->getMessage());
        }
    }
}