<?php
namespace Du;

class Request
{
	private  $_di;

	public function setDI(Service $di)
	{
		$this->_di = $di;
	}

	public function isPost()
	{
		if($_SERVER["REQUEST_METHOD"]=="POST")
		{
			return true;
		}
		return false;
	}

	public function isGET()
	{
		if($_SERVER["REQUEST_METHOD"]=="GET")
		{
			return true;
		}
		return false;
	}

	public function url()
	{
		return $_SERVER["HTTP_HOST"];
	}

	public function redirect($action="")
	{
	    if(__MODULE__!=$this->_di->module["defaultModule"])
	    {
	        $action = strtolower(__MODULE__)."\\".$action;
	    }
	    header("location:http://".$_SERVER['HTTP_HOST'].$_SERVER['CONTEXT_PREFIX']."/".$action);
	    exit();
	}
}