<?php
namespace Du;

use Du\View\Adapter\Php;

class View
{

    /**
     * 模板引擎
     * @var \Du\View\Template
     */
    private $engine;

    private $tVars = array();

    private $tPath = "";

    public function __construct()
    {
        $this->engine = new Php();
    }

    public function setVar($key, $value = "")
    {
        if ( is_array($key) )
        {
            $this->tVars = array_merge($this->tVars, $key);
        } else
        {
            $this->tVars[$key] = $value;
        }
    }

    public function loadEngine($engine)
    {
        $this->engine = $engine;
    }

    public function display($path = "")
    {
        $this->parsePath($path);
        $this->engine->render($this->tPath, $this->tVars);
    }

    public function setTheme($theme)
    {
        $this->engine->theme = $theme;
    }

    private function parsePath($path)
    {
        $pathInfo = explode(".", $path);
        $count = empty( $path ) ? 0 : count($pathInfo);
        switch ($count)
        {
            case 2:
                $this->tPath = $pathInfo;
                break;
            case 1:
                $pathInfo = array_merge(array(
                    __CONTROLLER__
                ), $pathInfo);
                $this->tPath = $pathInfo;
                break;
            default:
                $this->tPath = array(
                    __CONTROLLER__,
                    __ACTION__
                );
        }
    }
}