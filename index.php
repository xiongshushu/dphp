<?php
use Du\Application;
use Du\View;
use Du\View\Adapter\Smart;
use Du\Session;
use Du\Log;
use Du\Loader;

require 'Du/Loader.php';
//设置时间区
date_default_timezone_set("PRC");

$app = Loader::init();

$app->registe("view", function(){
   $view = new View();
   $smart = new Smart();
   $view->loadEngine($smart);
   return $view;
}); 

try {

    $app->handle($app);

}catch (\Exception $e){

    $app->response->show($e->getMessage());
}
