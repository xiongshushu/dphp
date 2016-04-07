<?php
namespace traits;

trait du
{
    private $services = array();

    public function make($name, $call)
    {
       $this->services[$name] = !is_callable($call) ? new $call() : $call();
    }

    /**
     * 调用一个服务
     * @param $name
     * @param string $service
     * @return mixed
     */
    public function in($name, $service = "")
    {
        if ( !isset($this->services[$name] ) )
        {
           $this->services[$name] = new $service;
        }
        return$this->services[$name];
    }

    /**
     * 实例化模型
     * @param $table
     * @param string $namespace
     * @return \model
     */
    public function model($table, $namespace = MODULE . "\\libs\\models")
    {
        return $this->load($table, $namespace);
    }

    /**
     * 调用模块的一些可用库
     * @param string $lib
     * @param string $namespace
     * @return object
     */
    public function load($lib, $namespace = MODULE . "\\libs\\")
    {
        return $this->in($namespace . $lib, $namespace . $lib);
    }

    /**
     * 加载返回格式为数组的php配置文件
     * @param $config
     * @param string $dir
     * @return array
     */
    public function config($config, $dir = APP_PATH . "/" . MODULE . "/config/")
    {
        if ( !isset($this->services[MODULE . $config] ) )
        {
           $this->services[MODULE . $config] = include $dir . $config . ".php";
        }
        return$this->services[MODULE . $config];
    }
}