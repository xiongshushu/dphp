<?php

class loader {

    static function init()
    {
        //基本常量
        define("DP_VER", "1.0.0 Beta", false);
        defined("CORE_PATH") OR define("CORE_PATH", __DIR__);
        defined("APP_PATH") OR define("APP_PATH", dirname(CORE_PATH));
        defined("ROOT_PATH") OR define("ROOT_PATH", dirname(APP_PATH));
        defined("LOG_PATH") OR define("LOG_PATH", ROOT_PATH . "/log/");

        /**
         * 实例化模型
         * @param $table
         * @param $module
         * @return \model
         */
        function M($table, $module = MODULE)
        {
            return P("models\\" . $table, $module);
        }

        /**
         * 调用模块的逻辑层
         * @param $module
         * @return object
         */
        function L($module = MODULE)
        {
            return pool::in($module . ".logic", $module . "\\libs\\logic");
        }

        /**
         * 调用模块通用包
         * @param string $lib
         * @param string $module
         * @return mixed
         */
        function P($lib, $module = MODULE)
        {
            return pool::in($module . "." . $lib, $module . "\\libs\\" . $lib);
        }

        /**
         * 加载返回格式为数组的php配置文件
         * @param $file
         * @return mixed
         */
        function C($file)
        {
            static $config = array();
            if (!isset($config[$file])) {
                $config[$file] = include $file;
            }
            return $config[$file];
        }

        /**
         * 记录日志
         * @param string $log
         * @param string $destination
         */
        function record($log, $destination = '')
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
            error_log("[" . date("Y-m-d H:i:s") . "] {$log}\r\n", 3, $destination);
        }

        //自动加载
        spl_autoload_register(function ($className) {
            $class = "/" . str_replace("\\", "/", $className) . ".php";
            $load = function ($class, array $loadDir) {
                foreach($loadDir as $dir){
                    if (file_exists($dir.$class)) {
                        return require_once $dir.$class;
                    }
                }
            };
            $load($class,array(CORE_PATH,APP_PATH,ROOT_PATH));
        });
    }
}
