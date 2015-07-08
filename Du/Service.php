<?php
namespace Du;

class Service
{
	public function __construct()
	{
			$this->{"router"}  = new Router();
			$this->{"response"}=new Response();
			$this->{"middleware"}=new Middleware();
			$this->{"request"}=new Request();
			$this->{"view"}=new View();
			$this->{"dispatcher"}=new Dispatcher();
			$this->{"module"} = [
		                "modules"=> ["Home","Admin"],
		                "defaultModule" => "Home",
		                "defaultController"=>"Home",
		                "defaultAcion"=>"index"
		            ];
	}

	public function registe($name,$call)
	{
		if(!is_callable ($call))
		{
			$this->$name= new $call;
		}else{
			$this->$name= $call();
		}
	}
}