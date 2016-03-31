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
    $corefile = CORE_PATH . $class;
    $appfile = APP_PATH . $class;
    if (file_exists($corefile)) {
        require_once $corefile;
    } elseif (file_exists($appfile)) {
        require_once($appfile);
    }
}

