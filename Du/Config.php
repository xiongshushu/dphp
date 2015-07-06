<?php
namespace Du;

class Config
{
	private static $config;

	static function php($name,$item="")
	{
		if (!isset(self::$config[$name]))
		{
			self::$config[$name] = require(CONF_PATH.DS.$name.".php");
		}
        return self::get($name,$item);
	}

	static  function get($name,$item="")
	{
		if (!empty($item))
		{
		    return self::$config[$name][$item];
		}
		return self::$config[$name];
	}
}