<?php
namespace Du\Config;

class Php
{
    private static $config;

    public function __construct($name, $item = "")
    {
        if ( !isset( self::$config[$name] ) )
        {
            self::$config[$name] = require( CONF_PATH . DS . $name . ".php" );
        }
        return empty( $item ) ? self::$config[$name] : self::$config[$name][$item];
    }
}