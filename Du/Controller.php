<?php
namespace Du;

class Controller
{

	public function input($key="")
	{
		return DI::$di->middleware->input($key);
	}

	public function redirect($action="",$base=FALSE)
	{
	    return DI::$di->request->redirect($action,$base);
	}

	public function __get($name)
	{
		if (strrchr($name,"Model")) {
			static $m;
			$model = "\\Models\\".$name;
			if (!isset($m[$model]))
			{
				$m[$model] = new $model;
			}
			return $m[$model];
		}
		return DI::$di->$name;
	}
}