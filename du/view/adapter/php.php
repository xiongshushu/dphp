<?php
namespace du\view\adapter;

use du\view\template;

class php extends template
{
    public $data;

    public function render($tPath, $tVars)
    {
        $path = join(DS, $tPath);
        $tplDir = ROOT_PATH . DS . __MODULE__ . DS . VIEW_NAME . DS . $this->theme . DS . __CONTROLLER__;
        $file = $tplDir . DS . $path . $this->suffix;
        if (file_exists($file)) {
            $this->data = file_get_contents($file);
            $this->fileName = $tPath[1] . $this->suffix;
            $this->cacheFile = CACHE_PATH . DS . $path . $this->suffix;
            $this->generateCache($this->data);
            if (is_file($this->cacheFile)) {
                extract($tVars);
                require $this->cacheFile;
            }
        }
    }

    public function result()
    {
        return $this->data;
    }
}