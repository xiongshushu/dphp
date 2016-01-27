<?php
namespace Du;

class Model {

	public function __call($name,$args)
	{
		return $this->call($name, $args);
	}

	private function call($name,$args)
	{
		if (!isset(di::$di->db)) {
			throw new error("DB driver missed!");
		}
		if (method_exists(di::$di->db,$name))
		{
			return call_user_func_array(array(di::$di->db,$name),$args);
		}
		return false;
	}
}