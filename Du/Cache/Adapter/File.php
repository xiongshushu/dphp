<?php
namespace Du\Cache\Adapter;
use Du\Cache\CacheInterFace;

class File implements CacheInterFace
{
    public $data=array();
    
    public $cacheFile;
    
    public function connect($option)
    {
        $cacheDir = CACHE_PATH.DS."File";
        $this->cacheFile = $cacheDir.DS.$option["temp"];
        if (!is_dir($cacheDir))
        {
            mkdir($cacheDir,0777,true);
            return;
        }
        if(file_exists($this->cacheFile))
        {
            $this->data = include $this->cacheFile;
        }
    }
    
    public function set($name, $value,$expire=null)
    {
        $this->data[$name] = $value;
        $this->data["expire"] = $_SERVER["REQUEST_TIME"]+$expire;
        $this->save();
       
    }
    
    public function get($name)
    {
        if (isset($this->data["expire"]) && $this->data["expire"]<$_SERVER["REQUEST_TIME"])
        {
            unset($this->data[$name]);
            $this->save();
            return false;
        }
        return isset($this->data[$name])?$this->data[$name]:false;
    }
    
    public function rm($name)
    {
        $this->data =array(); 
        $this->save();
    }
    
    public function clear()
    {
        unlink($this->cacheFile);
    }
    
    private function save()
    {
        file_put_contents($this->cacheFile,"<?php return ".str_replace(array(" ","\n"),"",var_export($this->data,true)).";?>");
    }
    
}