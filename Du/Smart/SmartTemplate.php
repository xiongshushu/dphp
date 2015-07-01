<?php
namespace Du\Smart;

class SmartTemplate
{
    public $tagLeft = "}";

    public $tagRight = "}";

    public $tplVar = array();

    public $tplCacheDir = "tpl_cache/";

    public $tplTheme = NULL;

    public $tplFile;

    public $cacheFile;

    public $tplFileSuffix = ".php";

    public $tplPath = "template/";

    public $cacheLifeTime = -1;

    public $tplData;

    public $layoutData='{MAIN}';

    private $tplFileName;

     public function init ()
    {
        $pathinfo = pathinfo($this->tplFile);
        $this->tplFileSuffix = ".".$pathinfo['extension'];
        $this->tplFileName =$pathinfo['basename'];
        $this->cacheFile =$this->tplCacheDir . $this->tplTheme . substr($this->tplFile, strlen($this->tplPath . $this->tplTheme));
        if (is_file($this->tplFile)) {
                $this->tplData = str_replace("{MAIN}", file_get_contents($this->tplFile), $this->layoutData);
        }
    }

    public function setVar ($key, $value = "")
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->tplVar[$k] = $v;
            }
        } else {
            $this->tplVar[$key] = $value;
        }
    }

    public function getResult ()
    {
        return $this->tplData;
    }

    public function output ()
    {
        $cplFile = substr($this->tplFile, strlen($this->tplPath));
        $this->buidCacheFile($cplFile);
        // 载入文件
        extract($this->tplVar);
        include $this->cacheFile;
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
    private function buidCacheFile ($cplFile)
    {
        if (($_SERVER['REQUEST_TIME'] - $this->getFiletime($this->cacheFile)) <= $this->cacheLifeTime) {
            return true;
        }
        $path = str_replace($this->tplFileName, "", $cplFile);
        if (! is_dir($this->tplCacheDir . $path)) {
            mkdir($this->tplCacheDir . $path,0777,true);
        }
        $fh = @fopen($this->cacheFile, "w");
        $parser = new SmartParse();
        $parser->compile($this->tplData,$this->tplPath,$this->tplFileSuffix);
        $this->tplVar = array_merge($this->tplVar, $parser->tplVar);
        $parser->data  = "<?php defined('DP_VER') or exit();?>\n".$parser->data;
        @fwrite($fh, $parser->data);
        @fclose($fh);
        return true;
    }
}