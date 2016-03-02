<?php
namespace du;

class Loader
{

    public static function Init()
    {
        define("DP_VER", "2.0.1 Beta", false);
        define("DS", DIRECTORY_SEPARATOR, false);
        defined("DEBUG") OR define("DEBUG", TRUE);
        defined("ROOT_PATH") OR define("ROOT_PATH", dirname(__DIR__));
        defined("MODEL_SPACE") OR define("MODEL_SPACE", "\\models");
        defined("CACHE_PATH") OR define("CACHE_PATH", ROOT_PATH . DS . "cache");
        defined("CLI_APP") or define("CLI_APP", "console");
        defined("VIEW_NAME") OR define("VIEW_NAME", "views");
        define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);
        //自动加载
        spl_autoload_register(function ($className)
        {
            $classFile = "/" . str_replace("\\", DS, $className) . ".php";
            $rootFile = ROOT_PATH . $classFile;
            if ( file_exists($rootFile) )
            {
                require_once( $rootFile );
            }
        });
    }
}