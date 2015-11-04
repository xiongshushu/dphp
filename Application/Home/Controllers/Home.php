<?php
namespace Home\Controllers;
use Du\Controller;

class Home extends Controller
{
    function indexAction()
    {
        $this->view->setVar("name","DuPHP");
    }
}