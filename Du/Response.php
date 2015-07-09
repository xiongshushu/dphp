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
     * 错误内容输出
     * @param string $msg
     * @param number $type 1：只提示错误文本（默认）；2：带调转的信息提示
     * @param string $url 跳转的地址；默认返回上一页；只有$type为2的时候，才有效；
     */
	public function error($msg,$time=5,$url="")
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