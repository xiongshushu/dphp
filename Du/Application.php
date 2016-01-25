<?php
namespace Du;

class Application
{
	public function handle()
	{
		   $query = DI::$di->router->parseUrl(DI::$di->module);
	       define("__MODULE__", ucfirst($query->defaultModule),false);
	       define("__CONTROLLER__", ucfirst($query->defaultController),false);
	       define("__ACTION__",$query->defaultAction,false);
	       try{
	             DI::$di->dispatcher->exec();
	             DI::$di->view->display();
	       }catch (Error $e){
	       	     DI::$di->response->show($e->getMessage(),"/");
	       }
	 }
}