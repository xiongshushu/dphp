<?php
namespace Home\Controller;
use Du\Controller;

class HomeController extends Controller
{
    function indexAction()
    {
        $this->view->setVar("name","DuPHP");
    }
}