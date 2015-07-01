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
}