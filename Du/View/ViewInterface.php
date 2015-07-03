<?php 
namespace Du\View;

interface ViewInterface
{
	/**
	 * 渲染显示视图到浏览器
	 */
	public function display(){}
	
	/**
	 * 不输出到浏览器,返回视图内容
	 */
	public function getResult(){}
}