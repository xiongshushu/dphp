<?php
namespace Du\View\Adapter;

class Smart{

    private $tpl;

    private $config;

    public function __construct(array $config=array())
    {
        $this->config = $config;
    }

    public function display($templateFile,$val) {
        $engine = new \Du\Smart\SmartTemplate();
        $engine->tplFile = $templateFile;
        $engine->cacheLifeTime = isset($this->config["cacheTime"])?$this->config["cacheTime"]:-1;
        $engine->tplCacheDir = APP_PATH .DS."Cache".DS.__MODULE__.DS.__CONTROLLER__;
        $engine->tplPath = str_replace(strrchr($templateFile,DS), "", $templateFile);
        if (isset($this->config["layout"]))
          {
           $engine->layoutData = file_get_contents($engine->tplPath.DS.$this->config["layout"]);
        }
        $engine->init();
        $engine->setVar($val);
        $engine ->output();
        $this->tpl = $engine;
        exit();
    }

    public function getResult()
    {
        return $this->tpl->getResult();
    }

    public function disableLayout()
    {
        unset($this->config["layout"]);
    }
}