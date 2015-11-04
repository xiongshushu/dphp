<?php
namespace Du;

class Application
{
	public function handle(Service $di)
	{
		   $query = $di->router->parseUrl($di->module);
	       define("__MODULE__", ucfirst($query->defautModule),false);
	       define("__CONTROLLER__", ucfirst($query->defaultController),false);
	       define("__ACTION__",$query->defaultAcion,false);
	       try{
	             $di->dispatcher->exec();
	             $di->view->display();
	       }catch (DUException $e){
	       	      $di->response->show($e->getMessage());
	       }
	 }
}