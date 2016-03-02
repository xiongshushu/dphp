<?php
namespace du\http;

class Router
{

    public $module = "home";

    public $controller = "home";

    public $action = "index";

    public $modules = array("home");

    public $rule = array();

    public function parseUrl()
    {
        $uri = $this->getUri();
        if ( !empty( $uri ) )
        {
            if ( in_array(ucfirst($uri[0]), $this->modules) )
            {
                $this->module = $uri[0];
                array_shift($uri);
            }
            if ( count($uri) >= 2 )
            {
                $param = array_splice($uri, 2);
                // 传递额外的参数给_GET;
                foreach ($param as $k => $v)
                {
                    if ( isset( $param[$k + 1] ) && !is_numeric($v) )
                    {
                        $_GET[$v] = $param[$k + 1];
                        unset( $param[$k + 1] );
                    } else
                    {
                        $_GET["param"] = $v;
                    }
                }
                $this->controller = $uri[0];
                $this->action = $uri[1];
            }
            if ( count($uri) == 1 )
            {
                $this->controller = $uri[0];
            }
        }
    }

    public function set(array $rule)
    {
        $this->rule = $rule;
    }

    public function getUri()
    {
        if ( isset( $_GET["_s"] ) )
        {
            $uri = str_replace(".html", "", trim($_GET["_s"], "/"));
            // 静态路由
            if ( in_array($uri, array_keys($this->rule)) )
            {
                $uri = $this->rule[$uri];
            }
            foreach ($this->rule as $pattern => $uri)
            {
                $uri = preg_replace($pattern, $uri, $_GET["_s"]);
            }
            return explode("/", $uri);
        }
        return isset( $argv ) ? $argv : array();
    }

    public function addModule($_)
    {
        $args = func_get_args();
        foreach ($args as $value)
        {
            if (!in_array($value, $this->modules)) {
                $this->modules[] = $value;
            }
        }
    }
}