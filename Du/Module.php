<?php
namespace Du;

class Module
{

    public $defautModule = "Home";

    public $defaultController = "Home";

    public $defaultAcion = "index";

    public $modules = array("Home");

    public function registeModule($_)
    {
        $args = func_get_args();
        foreach ($args as $value)
        {
            if (!in_array($value, $this->modules)) {
                $this->modules[] = $value;
            }
        }
    }

    public function setDefaultModule($module)
    {
        $this->defautModule = $module;
    }

    public function setDefaultController($module)
    {
        $this->defaultAcion = $module;
    }

    public function setDefaultAction($module)
    {
        $this->defaultAcion = $module;
    }
}