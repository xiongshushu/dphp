<?php
namespace Du;

class Module
{

    public $defautModule = "Home";

    public $defaultController = "Home";

    public $defaultAcion = "index";

    public $modules = array("Home");

    public function registeModule($module)
    {
        if (is_array($module)) {
            $this->modules = array_unique(array_merge($this->modules, $module));
            return true;
        }
        if (!in_array($module, $this->modules)) {
            $this->modules[] = $module;
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