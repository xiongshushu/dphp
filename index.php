<?php
use du\view;
use du\view\adapter\smart;
use du\loader;
use du\di;
use du\application;

require 'du/loader.php';
//设置时间区
date_default_timezone_set("PRC");

Loader::Init();
$di = new di();

$di->router->registerModule("Admin");
$di->session->start();

$di->register("view", function () {
    $view = new view();
    $smart = new smart();
    $view->loadEngine($smart);
    return $view;
});

$app = new application();
$app->handle($di);