<?php

//加载通用函数库
require "functions.php";

//基本常量
define("DP_VER", "1.0.0 Beta", false);
defined("APP_PATH") OR define("APP_PATH", dirname(__DIR__));
defined("ROOT_PATH") OR define("ROOT_PATH", dirname(APP_PATH));
defined("CORE_PATH") OR define("CORE_PATH", __DIR__);

//自动加载
spl_autoload_register(function($className){
    $class = "/" . str_replace("\\", "/", $className) . ".php";
    $load = function ($classfile) {
        if (file_exists($classfile)) {
            require_once $classfile;
        }
    };
    $load(ROOT_PATH . $class);
    $load(CORE_PATH . $class);
    $load(APP_PATH . $class);
});