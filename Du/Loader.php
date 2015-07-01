<?php
namespace Du;

class Loader {

    private $_di;

    public function __construct()
    {
        define("DP_VER", "2.0.1 Beta",false);
        define("DS", DIRECTORY_SEPARATOR,false) ;
        if(!defined("DEBUG")) {define("DEBUG",TRUE,false);}
        if(!defined("ROOT_PATH")) {
            exit("Please define constant 'ROOT_PATH' ");
        }
        if(!defined("APP_PATH")){define("APP_PATH",ROOT_PATH.DS."Application",false);}
        if(!defined("CONF_PATH")){define("CONF_PATH",APP_PATH.DS."Config",false);}
        //自动加载
        spl_autoload_register(function($cName){
            $cPath = str_replace("\\",DS,$cName).".php";
            if (file_exists(ROOT_PATH.DS.$cPath))
            {
                require(ROOT_PATH.DS.$cPath);
            }elseif(file_exists(APP_PATH.DS.$cPath)) {
                require(APP_PATH.DS.$cPath);
            }
        });
        $this->_di = new Service();
    }

    public function registeService()
    {
        return $this->_di;
    }

    public function registeModule($module)
    {
        $this->_di->module["modules"][] = $module;
    }

    public function setConfigDir($dir)
    {
        $this->_di->setConfigDir($dir);
    }
}