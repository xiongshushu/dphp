<?php 
namespace Du\View;

abstract class Engine
{
    public $theme = "";
    
    public $expireTime = -1;
    
    public $layout = "";
    
	/**
	 * 渲染显示视图到浏览器
	 * @param $path string 视图目录
	 * @param $mvc string 数组包含MVC的名称
	 */
	abstract function display($path,$mvc,$val,$suffix);
	
	/**
	 * 不输出到浏览器,返回视图内容
	 */
	abstract function getResult();
}