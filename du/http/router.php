<?php
namespace http;

class router
{
    private static $rule = array();

    private static $layers = array("admin");

    static function parseUrl()
    {
        $uri = self::getUri();
        if (!empty($uri)) {
            define("MODULE", $uri[0]);
            array_shift($uri);
            if (count($uri) >= 3) {
                $param = array_splice($uri, 3);
                // 额外的参数给_GET;
                foreach ($param as $k => $v) {
                    if (isset($param[$k + 1]) && !is_numeric($v)) {
                        $_GET[$v] = $param[$k + 1];
                        unset($param[$k + 1]);
                    } else
                        $_GET["param"] = $v;
                }
            }
            if (!empty($uri) && in_array($uri[0], self::$layers)) {
                define("LAYER", $uri[0]);
                array_shift($uri);
            }
        }
        defined("MODULE") OR define("MODULE", "home");
        defined("LAYER") OR define("LAYER", "");
        defined("CONTROLLER") OR define("CONTROLLER", empty($uri[0]) ? "index" : $uri[0]);
        defined("ACTION") OR define("ACTION", empty($uri[1]) ? "index" : $uri[1]);
    }

    static function set(array $rule)
    {
        self::$rule = $rule;
    }

    static function getUri()
    {
        if (isset($_GET["_s"])) {
            $uri = str_replace(".html", "", trim($_GET["_s"], "/"));
            foreach (self::$rule as $pattern => $url) {
                $uri = preg_replace($pattern, $url, $uri);
            }
            return explode("/", $uri);
        }
        return isset($argv) ? $argv : array();
    }

    static function registerLayer($_)
    {
        $args = func_get_args();
        foreach ($args as $value) {
            if (!in_array($value, self::$layers)) {
                self::$layers[] = $value;
            }
        }
    }
}