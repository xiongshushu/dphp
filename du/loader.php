<?php

class loader {

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
            return dm::in($module . ".logic", $module . "\\libs\\logic");
        }

        /**
         * 调用模块通用包
         * @param string $lib
         * @param string $module
         * @return mixed
         */
        function P($lib, $module = MODULE)
        {
            return dm::in($module . "." . $lib, $module . "\\libs\\" . $lib);
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
