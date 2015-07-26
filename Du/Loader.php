<?php
namespace Du;

class Loader {

    private $_di;

    public function __construct()
    {
        define("DP_VER", "2.0.1 Beta",false);
        define("DS", DIRECTORY_SEPARATOR,false) ;
        defined("DEBUG") OR define("DEBUG",TRUE);
        defined("ROOT_PATH") OR define("ROOT_PATH",dirname(__DIR__));
        defined("APP_PATH") OR define("APP_PATH",ROOT_PATH.DS."Application");
        defined("VIEW_PATH") OR define("VIEW_PATH",APP_PATH.DS."Views");
        defined("CONF_PATH") OR define("CONF_PATH",APP_PATH.DS."Config");
        defined("CACHE_PATH") OR define("CACHE_PATH",APP_PATH.DS."Cache");
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
    	if (is_array($module))
    	{
       		foreach ($module as $m)
       		{
       			$this->_di->module["modules"][] = $m;
       		}
    	}else{
    		$this->_di->module["modules"][] = $module;
    	}
    }
}