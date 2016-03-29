<?php
namespace traits;

trait template
{
    /**
     * 建立临时文件
     * @param $tData
     * @return bool
     */
    public function generateCache($target,$tData,$expireTime)
    {
        if ( ( $_SERVER['REQUEST_TIME'] - $this->getFileTime($target) ) > $expireTime )
        {
            $path = dirname($target);
            if ( !is_dir($path) )
            {
                mkdir($path, 0777, true);
            }
            return file_put_contents($target, $tData);
        }
        return false;
    }

    /**
     * 取文件的创建时间
     * @return number
     */
    public function getFileTime($file)
    {
        if ( @is_file($file) )
        {
            return filemtime($file);
        }
    }
}