<?php
namespace Du\View\Adapter;

use Du\View\Template;

class Smart extends Template
{

    /**
     * 解析引擎
     * 
     * @var \Du\Smart\SmartParse
     */
    public $smart;

    public function render($tPath, $tVars)
    {
        $smart = new \Du\Smart\SmartParse();
        $path = join(DS, $tPath);
        $this->cacheFile = CACHE_PATH . DS . $path . $this->suffix;
        $this->fileName = $tPath[2] . $this->suffix;
        $tpldir = VIEW_PATH . DS . $this->theme;
        $smart->compile(file_get_contents($tpldir . DS . $path . $this->suffix), $tpldir . DS . $tPath[0], $this->suffix);
        $this->buidCacheFile($smart->data);
        if (is_file($this->cacheFile)) {
            extract($tVars);
            require $this->cacheFile;
        }
    }

    public function getResult()
    {
        return $this->smart->data;
    }
}