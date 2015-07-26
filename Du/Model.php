<?php
namespace Du;

class Model {

	private  $_di ;
	
	public $cache = false; //是否使用缓存

	public $expire = 600; //缓存过期时间
	
	public function setDI(Service $di)
	{
		$this->_di = $di;
	}

	public function __call($name,$args)
	{
	   if ($this->cache)
	    {
	        $this->_di->cache->connect(array(
	            "temp"=>session_id().".php",
	        ));
	        $data =  $this->getcache($args);
	        if (!$data)
	        {
	           $data = $this->call($name,$args);
	           if (is_array($data))
	           {
	               $this->setcache($args, $data, $this->expire);
	           }
	        }
	        return $data;
	    }
	    return $this->call($name, $args);
	}
	
	private function call($name,$args)
	{
	    if (!isset($this->_di->db)) {
	        throw new DUException("You must registe a db driver first!");
	    }
	    if (method_exists($this->_di->db,$name))
	    {
	        return call_user_func_array(array($this->_di->db,$name),$args);
	    }
	    return FALSE;
	}
	
	private function getcache($name)
	{
	    return $this->_di->cache->get(hash("md5",serialize($name)));
	}
	
	private function setcache($name,array $value,$expire)
	{
	     $this->_di->cache->set(hash("md5",serialize($name)),$value,$expire);
	}
}