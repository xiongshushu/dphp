<?php
namespace Du;

class Controller
{
    public function input($key="")
    {
        return $this->form->input($key);
    }

    public function api($api,$module = __MODULE__)
    {
        $apiLib = $module."\\Apies\\".$api;
        if(class_exists($apiLib))
        {
            return new $apiLib;
        }
        $this->response->show("Couldn`t find API library : $apiLib !");
    }

    public function __get($name)
    {
        return DI::invoke($name);
    }
}