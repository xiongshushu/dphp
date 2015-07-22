<?php
namespace Du;

class Dispatcher
{
	private  $_di;

	public function __construct(Service $di)
	{
		$this->_di = $di;
	}

	public function exec()
	{
	    $ctr = __MODULE__."\\Controller\\".__CONTROLLER__."Controller";
	    $action = __ACTION__."Action";
		if(!class_exists($ctr))
		{
			throw  new DUException("Couldn't find controller: ".__CONTROLLER__);
		}
		if(!method_exists($ctr,$action))
		{
			throw  new DUException("Couldn't find  action : ".$action ." of ".__CONTROLLER__);
		}
		$call = new $ctr;
		$call->setDI($this->_di);
		if(method_exists($ctr,"main"))
		{
		    $call->main();
		}
	    $call->$action();
	}
}