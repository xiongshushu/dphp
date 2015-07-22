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
$loader = new Loader();

$di = $loader->registeService();

$di->registe("view", function() use ($di){
   $view = new View($di);
   $view->registerEngine(new Smart());
   return $view;
}); 

$di->registe("log", function(){
     $log = new Log();
     $log->log_path = APP_PATH.DS."Logs".DS;
     $log->log_time_format = "Y-m-d H:i:s";
     return $log;
});

$di->registe("session", function(){
    $session =  new Session();
    $session->start();
    return $session;
});

$app = new Application();

try {

    $app->handle($di);

}catch (\Exception $e){

    $di->response->prompt($e->getMessage());
}
