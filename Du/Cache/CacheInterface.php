<?php
namespace Du\Cache;

interface CacheInterface
{
    public function connect($option);
    
    public function set($name,$value,$expire);
    
    public function get($name);
    
    public function rm($name);
    
    public function clear();
}
