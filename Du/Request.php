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

	public function isGet()
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

	public function redirect($action="")
	{
	    header("location:".$action);
	}
}