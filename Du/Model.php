<?php
namespace Du;

class Model
{

    public $cache = false; //是否使用缓存

    public $expire = 600; //缓存过期时间

    public $ignore = array(); //指定忽略缓存的模块

    public function __call($name, $args)
    {
        if ($this->cache && !in_array(__MODULE__, $this->ignore)) {
            DI::$di->cache->connect(array(
                "temp" => session_id(),
            ));
            $data = $this->getcache($args);
            if (!$data) {
                $data = $this->call($name, $args);
                if (is_array($data)) {
                    $this->setcache($args, $data, $this->expire);
                }
            }
            return $data;
        }
        return $this->call($name, $args);
    }

    private function call($name, $args)
    {
        if (!isset(DI::$di->db)) {
            throw new Error("You must registe a db driver first!");
        }
        if (method_exists(DI::$di->db, $name)) {
            return call_user_func_array(array(DI::$di->db, $name), $args);
        }
        return FALSE;
    }

    private function getcache($name)
    {
        return DI::$di->cache->get(hash("md5", serialize($name)));
    }

    private function setcache($name, array $value, $expire)
    {
        DI::$di->cache->set(hash("md5", serialize($name)), $value, $expire);
    }
}