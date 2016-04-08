<?php
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
 * @param string $lib
 * @param string $module
 * @return mixed
 */
function P($lib, $module = MODULE)
{
    return di::invoke($module . "." . $lib, $module . "\\libs\\" . $lib);
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

