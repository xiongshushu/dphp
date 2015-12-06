<?php
namespace Du;

class View
{

    /**
     * 模板引擎
     * 
     * @var \Du\View\Template
     */
    private $engine;

    private $cache;

    private $tVars = array();

    private $tPath = "";

    public function setVar($key, $value = "")
    {
        if (is_array($key)) {
            $this->tVars = array_merge($this->tVars, $key);
        } else {
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
        exit();
    }

    public function setTheme($theme)
    {
        $this->engine->theme = $theme;
    }

    private function parsePath($path)
    {
        $pathinfo = explode(".", $path);
        $count = empty($path) ? 0 : count($pathinfo);
        switch ($count) {
            case 3:
                $this->tPath = $pathinfo;
                break;
            case 2:
                $pathinfo = array(
                    array(
                        __MODULE__
                    ),
                    $pathinfo
                );
                $this->tPath = $pathinfo;
                break;
            case 1:
                $pathinfo = array_merge(array(
                    __MODULE__,
                    __CONTROLLER__
                ), $pathinfo);
                $this->tPath = $pathinfo;
                break;
            default:
                $this->tPath = array(
                    __MODULE__,
                    __CONTROLLER__,
                    __ACTION__
                );
        }
    }
}