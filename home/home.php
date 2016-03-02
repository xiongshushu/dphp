<?php
namespace home;

use du\controller;

class home extends controller
{
    public function index()
    {
        $this->view->setVar("name","DuPHP");
    }
}