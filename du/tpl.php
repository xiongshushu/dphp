<?php

class tpl
{
    /**
     * 建立模板文件
     * @param $target
     * @param $tData
     * @param $expireTime
     * @return bool
     */
    static function create($target, $tData, $expireTime)
    {
        if (($_SERVER['REQUEST_TIME'] - filemtime($target)) > $expireTime) {
            $path = dirname($target);
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            return file_put_contents($target, $tData);
        }
        return false;
    }
}