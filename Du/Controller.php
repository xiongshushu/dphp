<?php
namespace Du;

class Controller
{
	private  $_di;

	public function setDI(Service $di)
	{
		$this->_di = $di;
	}

	public function input($key="")
	{
		$this->_di->middleware->setDI($this->_di);
		$input = $this->_di->middleware->input();
		return empty($key)?$input:$input[$key];
	}

	public function redirect($action)
	{
	    $this->_di->response->setDI($this->_di);
	    return $this->_di->response->redirect($action);
	}

	public function __get($name)
	{
		if (strrchr($name,"Model")) {
			$model = "\\Models\\".$name;
			$model = new $model;
			$model->setDI($this->_di);
			return $model;
		}
		return $this->_di->$name;
	}
}