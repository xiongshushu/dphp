<?php
namespace Du;

class Loader
{

    public static function Init()
    {
        define("DP_VER", "2.0.1 Beta", false);
        define("DS", DIRECTORY_SEPARATOR, false);
        defined("DEBUG") OR define("DEBUG", TRUE);
        defined("ROOT_PATH") OR define("ROOT_PATH", dirname(__DIR__));
        defined("APP_NAME") OR define("APP_NAME", "Web");
        defined("APP_PATH") OR define("APP_PATH", ROOT_PATH . DS . APP_NAME);
        defined("MODEL_SPACE") OR define("MODEL_SPACE", "\\Models");
        defined("CACHE_PATH") OR define("CACHE_PATH", APP_PATH . DS . "Cache");
        defined("CLI_APP") or define("CLI_APP", "Cli");
        defined("VIEW_NAME") OR define("VIEW_NAME", "Views");
        define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);
        //自动加载
        spl_autoload_register(function ($className) {
            $classFile = "/" . str_replace("\\", DS, $className) . ".php";
            $rootFile = ROOT_PATH . $classFile;
            $appFile = APP_PATH . $classFile;
            if (file_exists($rootFile)) {
                require_once($rootFile);
            } elseif (file_exists($appFile)) {
                require_once($appFile);
            }
        });
    }
}