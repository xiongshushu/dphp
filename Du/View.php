<?php
namespace Du;

class View
{

    private $engine;

    private $dir;

    private $cache;

    private $suffix = ".php";

    private $_vars = array();

    public function __construct()
    {
        $this->dir = VIEW_PATH;
    }

    public function setVar($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    public function setVars(array $val)
    {
        $this->_vars = array_merge($this->_vars, $val);
    }

    public function useEngine($engine)
    {
        $this->engine = $engine;
    }

    public function disableLayout()
    {
        $this->engine->disableLayout();
    }

    public function setViewsDir($tpldir)
    {
        $this->dir = $tpldir;
    }

    public function display($path="")
    {
        $mvc = $this->parsePath($path);
        $this->engine->display($this->dir,$mvc,$this->_vars,$this->suffix);
        exit();
    }

    private function parsePath($path)
    {
        $pathinfo = explode(".", $path);
        $count = empty($path)?0:count($pathinfo);
        switch ($count) {
            case 3:
                return $pathinfo;
            case 2:
                $pathinfo = array(array(__MODULE__) ,$pathinfo);
                return $pathinfo;
            case 1:
                $pathinfo = array_merge(array( __MODULE__, __CONTROLLER__) , $pathinfo);
                return $pathinfo;
            default:
                return array(__MODULE__, __CONTROLLER__,__ACTION__);
        }
    }
}