<?php
namespace Du;

class Response
{
    private  $_di ;

    private $tpl = "Tpl/show.php";
    
    public function __construct(Service $di)
    {
        $this->_di = $di;
    }

    /**
     * 文本内容输出到浏览器
     * @param string $msg
     * @param string $url 跳转的地址；补位空的时候有效；
     * @param number $time 跳转时间.跳转地址不为空时有效
       */
	public function show($msg,$url="",$time=5)
	{
	    header("Content-type: text/html; charset=utf-8");
		include($this->tpl);
	    die();
	}
    
	public function setShowTpl($tpl)
	{
	    $this->tpl = $tpl;
	}
	
	public function json(array $data)
	{
		header("Content-Type:application/json;charset:utf-8");
		exit(json_encode($data,true));
	}
}