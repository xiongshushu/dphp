<?php
namespace Du\View;

abstract class Template
{
    public $suffix = ".php";
    
    public $theme = "";

    public $expireTime = - 1;

    public $layout = "";

    public $cacheFile;
    
    public $fileName;

    abstract function render($tPath, $tVars);

    abstract function getResult();

    /**
     * 建立临时文件
     * @param $tData
     * @return bool
     */
    public function buildCacheFile($tData)
    {
        if (($_SERVER['REQUEST_TIME'] - $this->getFileTime($this->cacheFile)) <= $this->expireTime) {
            return true;
        }
        $path = str_replace($this->fileName, "", $this->cacheFile);
        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $fh = @fopen($this->cacheFile, "w");
        @fwrite($fh, $tData);
        @fclose($fh);
        return true;
    }

    /**
     * 取文件的创建时间
     * @return number
     */
    public function getFileTime($fileName)
    {
        if (@is_file($fileName)) {
            return filemtime($fileName);
        }
    }
}