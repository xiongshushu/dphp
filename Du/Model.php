<?php
namespace Du;

class Model {

	public function __call($name,$args)
	{
		return $this->call($name, $args);
	}

	private function call($name,$args)
	{
		if (!isset(DI::$di->db)) {
			throw new error("you must register a db driver !");
		}
		if (method_exists(DI::$di->db,$name))
		{
			return call_user_func_array(array(di::$di->db,$name),$args);
		}
		return false;
	}
}