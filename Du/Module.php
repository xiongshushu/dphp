<?php
namespace Du;

class Module
{

    public $defaultModule = "Home";

    public $defaultController = "Home";

    public $defaultAction = "index";

    public $modules = array("Home");

    public function addModule($_)
    {
        $args = func_get_args();
        foreach ($args as $value)
        {
            if (!in_array($value, $this->modules)) {
                $this->modules[] = $value;
            }
        }
    }

    public function setModule($module)
    {
        $this->defaultModule = $module;
    }

    public function setController($module)
    {
        $this->defaultController = $module;
    }

    public function setAction($module)
    {
        $this->defaultAction = $module;
    }
}