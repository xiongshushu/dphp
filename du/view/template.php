<?php
namespace du\view;

abstract class template
{
    public $suffix = ".php";

    public $theme = "";

    public $expireTime = -1;

    public $layout = "";

    public $cacheFile;

    public $fileName;

    abstract function render($tPath, $tVars);

    abstract function result();

    /**
     * 建立临时文件
     * @param $tData
     * @return bool
     */
    public function generateCache($tData)
    {
        if ( ( $_SERVER['REQUEST_TIME'] - $this->getFileTime($this->cacheFile) ) > $this->expireTime )
        {
            $path = str_replace($this->fileName, "", $this->cacheFile);
            if ( !is_dir($path) )
            {
                mkdir($path, 0777, true);
            }
            return file_put_contents($this->cacheFile, $tData);
        }
        return false;
    }

    /**
     * 取文件的创建时间
     * @return number
     */
    public function getFileTime($fileName)
    {
        if ( @is_file($fileName) )
        {
            return filemtime($fileName);
        }
    }
}