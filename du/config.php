<?php

class config
{
    /**
     * 加载返回格式为数组的php配置文件
     * @param $file
     * @return mixed
     */
    static function php($file)
    {
        static $config = array();
        if (!isset($config[$file])) {
            $config[$file] = include $file;
        }
        return $config[$file];
    }
}