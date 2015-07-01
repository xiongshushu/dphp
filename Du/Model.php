<?php
namespace Du;

class Model {

	private  $_di ;

	public function setDI(Service $di)
	{
		$this->_di = $di;
	}

	public function __call($name,$arg)
	{
		if (!isset($this->_di->db)) {
			throw new DUException("You must registe db driver first!");
		}
		return $this->_di->db->$name($arg[0],$arg[1]);
	}
}