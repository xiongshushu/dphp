<?php
namespace Du;

class Router
{
    public $rule = array();

	public function parseUrl(array $config)
    {
        if (isset($_GET["_s"])) {
            $uri = str_replace(".html", "", trim($_GET["_s"], "/"));
            if (in_array($uri,array_keys($this->rule))) {
                $uri = $this->rule[$uri];
            }
            $uri = explode("/",$uri);
            if ($config["modules"] && in_array(ucfirst($uri[0]), $config["modules"])) {
              $module = $uri[0];
                array_shift($uri);
            } else {
               $module = $config["defaultModule"];
            }
            if (count($uri) >= 2) {
               $param = array_splice($uri, 2);
                // 传递额外的参数给_GET;
                foreach ($param as $k=>$v){
                    if (isset($param[$k + 1]) && ! is_numeric($v)) {
                      $_GET[$v] = $param[$k + 1];
                        unset($param[$k + 1]);
                    } else {
                      $_GET["param"] = $v;
                    }
                }
                $uri["module"] = $module;
                return $uri;
            }
            if ($config["modules"] && empty($uri)) {
               $uri[] = $config["defaultController"];
               $uri[] = $config["defaultAcion"];
            } else {
                $uri[] = $config["defaultAcion"];
            }
            $uri["module"] = $module;
            return $uri;
        }
        return [$config["defaultController"],$config["defaultAcion"],"module"=>$config["defaultModule"]];
    }

    public function set($rule)
    {
        $this->rule = $rule;
    }
}