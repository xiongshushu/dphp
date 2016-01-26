<?php
namespace Home;
use Du\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->view->setVar("name","DuPHP");
    }
}