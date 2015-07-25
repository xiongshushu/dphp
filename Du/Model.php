<?php
namespace Du;

class Model {

	private  $_di ;

	public function setDI(Service $di)
	{
		$this->_di = $di;
	}

	public function __call($name,$args)
	{
		if (!isset($this->_di->db)) {
			throw new DUException("You must registe db driver first!");
		}
		if (method_exists($this->_di->db,$name))
		{
		  return call_user_func_array(array($this->_di->db,$name),$args);
		}
		return FALSE;
	}
}