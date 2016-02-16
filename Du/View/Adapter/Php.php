<?php
namespace Du\View\Adapter;

use Du\View\Template;

class Php extends Template
{
    public $data;

    public function render($tPath, $tVars)
    {
        $path = join(DS, $tPath);
        $tplDir = APP_PATH . DS . __MODULE__ . DS . VIEW_NAME . DS . $this->theme;
        $file = $tplDir . DS . $path . $this->suffix;
        if (file_exists($file)) {
            $this->data = file_get_contents($file);
            $this->fileName = $tPath[1] . $this->suffix;
            $this->cacheFile = CACHE_PATH . DS . $path . $this->suffix;
            $this->buildCacheFile($this->data);
            if (is_file($this->cacheFile)) {
                extract($tVars);
                require $this->cacheFile;
            }
        }
    }

    public function getResult()
    {
        return $this->data;
    }
}