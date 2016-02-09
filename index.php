<?php
use Du\View;
use Du\View\Adapter\Smart;
use Du\Loader;
use Du\DI;
use Du\Application;

$start = microtime();
$start_m = memory_get_usage();

require 'Du/Loader.php';
//设置时间区
date_default_timezone_set("PRC");

Loader::Init();
$di = new DI();

$di->register("view", function(){
   $view = new View();
   $smart = new Smart();
   $view->loadEngine($smart);
   return $view;
}); 

$app = new Application();
$app->handle($di);
echo microtime() - $start;
echo "</br>";
echo memory_get_usage() - $start_m;