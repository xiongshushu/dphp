<?php
/**
 * 实例化模型
 * @param $table
 * @param $module
 * @return \model
 */
function M($table, $module = MODULE)
{
    return L("models\\" . $table, $module);
}

/**
 * 调用模块的逻辑层
 * @param string $lib
 * @param string $module
 * @return mixed
 */
function L($lib, $module = MODULE)
{
    return di::invoke($module . "." . $lib, $module . "\\libs\\" . $lib);
}

/**
 * 自动加载
 * @param $className
 */
function autoload($className)
{
    $class = "/" . str_replace("\\", "/", $className) . ".php";
    $load = function ($classfile) {
        if (file_exists($classfile)) {
            require_once $classfile;
        }
    };
    $load(ROOT_PATH . $class);
    $load(CORE_PATH . $class);
    $load(APP_PATH . $class);
}

