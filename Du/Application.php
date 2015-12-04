<?php
namespace Du;

class Application
{
	public function handle()
	{
		   $query = DI::$di->router->parseUrl(DI::$di->module);
	       define("__MODULE__", ucfirst($query->defautModule),false);
	       define("__CONTROLLER__", ucfirst($query->defaultController),false);
	       define("__ACTION__",$query->defaultAcion,false);
	       try{
	             DI::$di->dispatcher->exec();
	             DI::$di->view->display();
	       }catch (DUException $e){
	       	     DI::$di->response->show($e->getMessage(),"/");
	       }
	 }
}