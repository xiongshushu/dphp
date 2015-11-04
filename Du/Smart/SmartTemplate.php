<?php
namespace Du\Smart;

class SmartTemplate
{
    public $vars = array();

    public $filePath;
 
    public $theme = "";

    public $cacheFile;

    public $suffix = ".php";

    public $expireTime = -1;

    public $data;

    public $fileName;

    public function setVar ($key, $value = "")
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->vars[$k] = $v;
            }
        } else {
            $this->vars[$key] = $value;
        }
    }

    public function getResult ()
    {
        return $this->data;
    }

    public function output ()
    {
        $this->buidCacheFile();
        // 载入文件
        extract($this->vars);
        if (is_file($this->cacheFile)){
            include $this->cacheFile;
        }
    }

    /**
     * 取文件的创建时间
     *
     * @return number
     */
    private function getFiletime ($filename)
    {
        if (@is_file($filename)) {
            return filemtime($filename);
        }
    }

    /**
     * 建立临时文件
     *
     * @param string $cplFile
     */
    private function buidCacheFile ()
    {
        if (($_SERVER['REQUEST_TIME'] - $this->getFiletime($this->cacheFile)) <= $this->expireTime) {
            return true;
        }
        $path = str_replace($this->fileName, "", $this->cacheFile);
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        $fh = @fopen($this->cacheFile, "w");
        $parser = new SmartParse();
        $parser->compile($this->data,$this->filePath,$this->suffix);
        $parser->data  = "<?php defined('DP_VER') or exit();?>\n".$parser->data;
        @fwrite($fh, $parser->data);
        @fclose($fh);
        return true;
    }
}