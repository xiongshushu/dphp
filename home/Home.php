<?php
namespace home;

use du\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->view->setVar("name","DuPHP");
    }
}