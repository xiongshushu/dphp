<?php
namespace Du;

class View {

	private $engine;

	private $tplDir;

	private $suffix = ".php";

	protected $_vars = [];

	private  $_di;

	public function __construct(Service $di)
	{
		$this->_di = $di;
	}

	public function setVar($key,$value)
	{
		$this->_vars[$key] = $value;
	}

	public function setSuffix($suffix)
	{
		$this->suffix = $suffix;
	}

	public function setVars(array $val)
	{
		$this->_vars = array_merge($this->_vars,$val);
	}

	public function registerEngine($engine)
	{
		$this->engine = $engine;
	}

	public function disableLayout()
	{
	    $this->engine->disableLayout();
	}

	public function setViewsDir($tpldir)
	{
		$this->tplDir = $tpldir;
	}

	public function display($path)
	{
		if (!$this->engine) {
		    $path = $this->parsePath($path);
			if (is_file($path)){
			  extract($this->_vars);
			  require ($path);
			}
		}else{
			$this->engine->display($this->parsePath($path),$this->_vars);
		}
	}

	public function parsePath($path)
	{
		if (!$this->tplDir) {
			return APP_PATH.DS."Views".DS.$path.$this->suffix;
		}
		return $this->tplDir.DS.$path.$this->suffix;
	}
}