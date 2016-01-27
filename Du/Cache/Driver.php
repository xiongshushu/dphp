<?php
namespace Du\Cache;

interface Driver
{
    public function connect($option);
    
    public function set($name,$value,$expire);
    
    public function get($name);
    
    public function remove($name);
    
    public function clear();
}
