<?php
namespace Du;

class Response
{
    private  $_di ;

    public function setDI(Service $di)
    {
        $this->_di = $di;
    }

    /**
     * 文本内容输出到浏览器
     * @param string $msg
     * @param number $time 跳转时间.跳转地址不为空时有效
     * @param string $url 跳转的地址；补位空的时候有效；
       */
	public function prompt($msg,$time=5,$url="")
	{
	    header("Content-type: text/html; charset=utf-8");
	    if (!empty($url))
	    {
		    echo $msg."<p>页面自动 <a id=\"href\" href=\"$url\">跳转</a> 等待时间： <b id=\"wait\">$time</b></p></div><script type=\"text/javascript\">(function(){var wait = document.getElementById('wait'),href = document.getElementById('href').href;var interval = setInterval(function(){var time = --wait.innerHTML;if(time <= 0) {location.href = href;clearInterval(interval);};}, 1000);})();</script>";
	    }else {
	    	echo $msg;
	    }
	}

	public function json(array $data)
	{
		header("Content-Type:application/json;charset:utf-8");
		exit(json_encode($data,true));
	}

	public function redirect($action)
	{
	    if(__MODULE__!=$this->_di->module["defaultModule"])
	    {
	        $action = strtolower(__MODULE__)."\\".$action;
	    }
	    header("location:http://".$_SERVER['HTTP_HOST'].$_SERVER['CONTEXT_PREFIX']."/".$action);
	    exit();
	}
}