<?php
namespace Du;

class Router
{

    public $rule = array();

    public function parseUrl(Module $mod)
    {
        if (isset($_GET["_s"])) {
            $uri = str_replace(".html", "", trim($_GET["_s"], "/"));
            // 静态路由
            if (in_array($uri, array_keys($this->rule))) {
                $uri = $this->rule[$uri];
            }
            foreach ($this->rule as $pattern => $uri) {
                $uri = preg_replace($pattern, $uri, $_GET["_s"]);
            }
            $uri = explode("/", $uri);
            if (in_array(ucfirst($uri[0]), $mod->modules)) {
                $mod->defautModule = $uri[0];
                array_shift($uri);
            }
            if (count($uri) >= 2) {
                $param = array_splice($uri, 2);
                // 传递额外的参数给_GET;
                foreach ($param as $k => $v) {
                    if (isset($param[$k + 1]) && ! is_numeric($v)) {
                        $_GET[$v] = $param[$k + 1];
                        unset($param[$k + 1]);
                    } else {
                        $_GET["param"] = $v;
                    }
                }
                $mod->defaultController = $uri[0];
                $mod->defaultAcion = $uri[1];
            }elseif(!empty($uri)){
                $mod->defaultController = $uri[0];
            }
        }
        return $mod;
    }

    public function set(array $rule)
    {
        $this->rule = $rule;
    }
}