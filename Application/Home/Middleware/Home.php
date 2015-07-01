<?php
namespace Home\Middleware;

use Du\Middleware;

class Home extends Middleware
{
    public function index()
    {
        return array(
            "name"=>md5($_GET['name']),
        );
    }
}