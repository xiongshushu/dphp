<?php
namespace Du\View\Adapter;

use Du\View\Engine;

class Smart extends Engine
{

    private $engine;

    private $config;

    public function display($path, $mvc, $val, $suffix)
    {
        $this->engine = new \Du\Smart\SmartTemplate();
        // 初始化一系列数据
        $this->engine->suffix = $suffix;
        $this->engine->fileName = $mvc[2] . $suffix;
        $this->engine->theme = $this->theme;
        $this->engine->filePath = $path . DS .$this->engine->theme . DS . $mvc[0];
        $this->engine->expireTime = $this->expireTime;
        $this->engine->cacheFile = CACHE_PATH . DS . "Compile" . DS . $this->engine->theme . DS . $mvc[0] . DS . $mvc[1] . DS . $this->engine->fileName;
        $file = $this->engine->filePath . DS . $mvc[1] . DS . $this->engine->fileName;
        if (! empty($this->layout)) {
            $this->engine->data = str_replace("{MAIN}", file_get_contents($file), file_get_contents($this->engine->filePath . DS . $this->layout));
        } elseif (is_file($file)) {
            $this->engine->data = file_get_contents($file);
        }
        $this->engine->setVar($val);
        $this->engine->output();
        return;
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