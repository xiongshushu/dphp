<?php
namespace Du;

class Cli
{
	public function handle($argv)
	{
		   if (php_sapi_name()!="cli"){
		       throw  new DUException("please run in cli mode!\n");
		   }
		   if (empty($argv[1])){
		       throw  new DUException("cli task no found!\n");
		   }
		   if (empty($argv[2])){
		       throw  new DUException("cli task action no found!\n");
		   }
	       define("__MODULE__","Task",false);
	       define("__CONTROLLER__", ucfirst($argv[1]),false);
	       define("__ACTION__",ucfirst($argv[2]),false);
	       try{
	             DI::$di->dispatcher->cliExec();
	       }catch (DUException $e){
	       	      DI::$di->response->show($e->getMessage());
	       }
	 }
}