<?php
namespace Du;

class Middleware
{
	private  $_di ;

	public function setDI(Service $di)
	{
		$this->_di = $di;
	}

    public function scope($val,$max,$min=0)
    {
        $len = mb_strlen($val);
        if (!$len>$min && $len<=$max)
        {
            return TRUE;
        }
        return false;
    }

	public function cep($needle,$replace="")
	{
		if(empty($needle))
		{
		   $needle = $replace;
	       }
		return $needle;
	}

	public function input()
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
	       return $this->parseInput($call->$method());
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

	public function get()
	{
		return $this->removeXSS($_GET);
	}

	public function post()
	{
		return $this->removeXSS($_POST);
	}

	public function error($error,$json=true,$jumpUrl='',$waitSecond=5)
	{
	    if ($json)
	    {
	        header("Content-Type:application/json;charset:utf-8");
	        exit(json_encode($error));
	    }
	    exit($error);
	}

	public function __get($name)
	{
        return $this->_di->$name;
	}
}
