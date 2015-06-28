<?php
namespace Admin\Controller;
use Du\Controller;

class HomeController extends Controller
{
    function indexAction()
    {
        $this->view->setVar("name","DuPHP");
    }
}