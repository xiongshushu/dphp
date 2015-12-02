<?php
namespace Du;

class Request
{
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

	public function ip()
	{
	    return $_SERVER['REMOTE_ADDR'];
	}

	public function redirect($action="",$base=false)
	{
	    if ($base)
	    {
	        header("location:".$action);
	        return;
	    }else{
	        $action = strtolower(__MODULE__)."/".$action;
	    }
	    header("location:http://".$_SERVER['HTTP_HOST'].$_SERVER['CONTEXT_PREFIX']."/".$action);
	}
}