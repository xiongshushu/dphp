<?php
namespace Du;

class Controller
{

    public function __get($name)
    {
        return DI::invoke($name);
    }
}