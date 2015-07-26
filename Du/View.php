<?php
namespace Du;

class View {

	private $engine;

	private $tplDir;

	private $cache;
	
	private $suffix = ".php";

	protected $_vars = [];

	public function __construct()
	{
	   $this->tplDir = VIEW_PATH;
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
	
	public function setCacheEngine($engine)
	{
	    $this->cache = $engine;
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
	    $path = $this->parsePath($path);
		if (!$this->engine) {
			if (is_file($path)){
			  extract($this->_vars);
			  require ($path);
			}
		}else{
			$this->engine->display($path,$this->_vars);
		}
	}

	public function parsePath($path)
	{
		return $this->tplDir.DS.$path.$this->suffix;
	}
}