<?php
namespace Du;

class Service
{
	public function __construct()
	{
			$this->{"router"}  = new Router();
			$this->{"response"}=new Response($this);
			$this->{"middleware"}=new Middleware($this);
			$this->{"request"}=new Request($this);
			$this->{"view"}=new View($this);
			$this->{"cookie"}=new Cookie();
			$this->{"dispatcher"}=new Dispatcher($this);
			$this->{"module"} = [
		                "modules"=> ["Home"],
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