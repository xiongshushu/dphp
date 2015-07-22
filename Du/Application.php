<?php
namespace Du;

class Application
{
	public function handle($di)
	{
		   $query = $di->router->parseUrl($di->module);
	       define("__MODULE__", ucfirst($query["module"]),false);
	       define("__CONTROLLER__", ucfirst($query[0]),false);
	       define("__ACTION__",$query[1],false);
	       try{
	             $di->dispatcher->exec();
	             $di->view->display(__MODULE__.DS.__CONTROLLER__.DS.__ACTION__);
	       }catch (DUException $e){
	       	      $di->response->prompt($e->getMessage());
	       }
	 }
}