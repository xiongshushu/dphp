<?php
use du\View;
use du\view\adapter\Smart;
use du\Loader;
use du\DI;
use du\Application;

require 'du/Loader.php';
//设置时间区
date_default_timezone_set("PRC");

Loader::Init();
$di = new DI();

$di->router->addModule("Admin");
$di->session->start();

$di->register("view", function () {
    $view = new View();
    $smart = new Smart();
    $view->loadEngine($smart);
    return $view;
});

$app = new Application();
$app->handle($di);