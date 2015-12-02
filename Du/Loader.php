<?php
namespace Du;

class Loader {

    public static function init()
    {
        define("DP_VER", "2.0.1 Beta",false);
        define("DS", DIRECTORY_SEPARATOR,false) ;
        defined("DEBUG") OR define("DEBUG",TRUE);
        defined("ROOT_PATH") OR define("ROOT_PATH",dirname(__DIR__));
        defined("APP_PATH") OR define("APP_PATH",ROOT_PATH.DS."Application");
        defined("VIEW_PATH") OR define("VIEW_PATH",APP_PATH.DS."Views");
        defined("CONF_PATH") OR define("CONF_PATH",APP_PATH.DS."Config");
        defined("CACHE_PATH") OR define("CACHE_PATH",APP_PATH.DS."Cache");
        defined("_PUBLIC_") OR define("_PUBLIC_","/Public");
        defined("CLI_MOD") or define("CLI_MOD", "Cron");
        //自动加载
        spl_autoload_register(function($cName){
            $cPath = str_replace("\\",DS,$cName).".php";
            if (file_exists(ROOT_PATH.DS.$cPath))
            {
                require_once(ROOT_PATH.DS.$cPath);
            }elseif(file_exists(APP_PATH.DS.$cPath)) {
                require_once(APP_PATH.DS.$cPath);
            }
        });
       return new Application();
    }
}