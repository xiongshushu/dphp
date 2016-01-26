<?php
namespace Du\Cache;

interface Cache
{
    public function connect($option);
    
    public function set($name,$value,$expire);
    
    public function get($name);
    
    public function rm($name);
    
    public function clear();
}
