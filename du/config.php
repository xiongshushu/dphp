<?php
namespace du;

class config
{
    private $path;

    public function php($name, $item = "")
    {
        static $config = array();
        if (!isset($config[$name])) {
            $config[$name] = $this->readFile($name . ".php");
        }
        return empty($item) ? $config[$name] : $config[$name][$item];
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    private function readFile($file)
    {
        return require $this->path . $file;
    }
}