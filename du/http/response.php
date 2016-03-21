<?php
namespace du\http;

class response
{
    private $template = "Html/Show.php";

    public function success($msg, $url = "./", $time = 5)
    {
        $this->html($msg, $url, $time, ":)");
    }

    public function error($msg, $url = "./", $time = 5)
    {
        $this->html($msg, $url, $time, ":(");
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function json(array $data)
    {
        header("Content-Type:application/json;charset:utf-8");
        exit(json_encode($data, true));
    }

    private function html($msg, $url, $time, $tag)
    {
        exit('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>系统信息提示</title><style type="text/css">* {	padding: 0;	margin: 0;}body {	background: #fff;	font-family: \'微软雅黑\';	color: #333;	font-size: 16px;}.system-message {	padding: 24px 48px;}.system-message h1 {	font-size: 100px;	font-weight: normal;	line-height: 120px;	margin-bottom: 12px;}.system-message .jump {	padding-top: 10px}.system-message .jump a {	color: #333;}.system-message .success, .system-message .error {	line-height: 1.8em;	font-size: 36px}.system-message .detail {	font-size: 12px;	line-height: 20px;	margin-top: 12px;	display: none}</style></head><body>	<div class="system-message"><h1>' . $tag . '</h1><p class="error">' . $msg . '</p><p class="detail"></p>		<p class="jump">页面自动<a id="href" href="' . $url . '">跳转</a> 等待时间：<b id="wait">' . $time . '</b>	</p>	</div>	<script type="text/javascript">(function(){var wait = document.getElementById(\'wait\'),href = document.getElementById(\'href\').href;var interval = setInterval(function(){	var time = --wait.innerHTML;if(time == 0) {location.href = href;clearInterval(interval);};},1000);})();</script></body></html>');
    }

    public function api($msg = "", $data = array(), $code = 200)
    {
        die(
            $this->json(array(
                "code" => $code,
                "msg" => $msg,
                "data" => $data,
            ))
        );
    }

}