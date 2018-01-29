<?php

namespace home;

use view;

class index
{
    public function index()
    {
        view::assign("index", array(
            "hello" => "hello world!"
        ));
    }
}