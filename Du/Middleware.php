<?php
namespace Du;

class Middleware
{
	private  $_di ;

	public function __construct(Service $di)
	{
		$this->_di = $di;
	}

	public function isEmpty($data,$msg)
	{
	    if (empty($data))
	    {
	        throw new FormException($msg);
	    }
	}

	public function scope($val,$max,$min=0,$msg)
	{
	    $len = mb_strlen($val);
	    if ($len<$min ||$len>$max)
	    {
	        throw new FormException($msg);
	    }
	}

	public function compare($val1,$val2,$msg)
	{
	    if ($val1 !=$val2)
	    {
	        throw new FormException($msg);
	    }
	}

	public function match($subject,$pattern,$msg)
	{
	   if (!preg_match($pattern, $subject))
	    {
	        throw new FormException($msg);
	    }
	}

	public function replace($val,$replace)
	{
        return empty($val)?$replace:$val;
	}

	public function post($key="")
	{
	    if (empty($key))
	    {
	       return $_POST;
	    }
        return isset($_POST[$key])?$_POST[$key]:'';
	}

	public function get($key="")
	{
	    if (empty($key))
	    {
	        return $_GET;
	    }
	    return isset($_GET[$key])?$_GET[$key]:'';
	}

	public function input($key="")
	{
	    $form = __MODULE__."\\Middleware\\".__CONTROLLER__;
		if(!class_exists($form))
		{
			throw new DUException("Couldn't find middleware: ".$form);
		}
		if(!method_exists($form,__ACTION__))
		{
			throw new DUException("Couldn't find  method : ".__ACTION__ ." of ".$form);
		}
		$call = new $form;
		$method = __ACTION__;
		$call->setDI($this->_di);
	    $input  =  $this->parseInput($call->$method());
	    return empty($key)?$input:$input[$key];
	}

	public function parseInput($data)
	{
		if(empty($data) && $data != 0)
		{
			return [];
		}
		$data = $this->removeXSS($data);
		if (!is_array($data)){
            return $data;
		}
		foreach ($data as  $rKey=>$rValue){
			if(strrpos($rKey,"i_")!==false)
			{
				$data[$rKey] = (int) $rValue;
			}
		}
		return $data;

	}

       public function removeXSS($val) {
          if (!is_array($val)) {
               return htmlspecialchars(str_replace(["\n","\t","\r"], "", trim($val)));
          }
	      foreach ($val as $k=>$v)
	      {
	          if (is_array($v))
	          {
	              $this->removeXSS($v);
	          }else{
	              $val[$k] = htmlspecialchars(str_replace(["\n","\t","\r"], "", trim($v)));
	          }
	      }
	       return $val;
	}

	public function __get($name)
	{
        return $this->_di->$name;
	}
}
