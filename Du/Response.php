<?php
namespace Du;

class Response
{
    private $template = "Html/Show.php";

    /**
     * 文本内容输出到浏览器
     * @param string $msg
     * @param string $url 跳转的地址；补位空的时候有效；
     * @param int $time 跳转时间.跳转地址不为空时有效
	 */
	public function show($msg,$url="",$time=5)
	{
	    header("Content-type: text/html; charset=utf-8");
		require($this->template);
	    exit(0);
	}
    
	public function setTemplate($template)
	{
	    $this->template = $template;
	}
	
	public function json(array $data)
	{
		header("Content-Type:application/json;charset:utf-8");
		exit(json_encode($data,true));
	}
}