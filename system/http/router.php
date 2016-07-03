<?php
namespace http;

class router
{
    private static $rule = array();

    private static $modules = array("admin");

    static $child = "";

    static $module = "home";

    static $controller = "index";

    static $action = "index";

    static function parseUrl()
    {
        $uri = self::getUri();
        if (!empty($uri[0])) {
            self::$module = $uri[0];
            array_shift($uri);
            if (isset($uri[0]) && in_array($uri[0], self::$modules)) {
                self::$child = $uri[0];
                array_shift($uri);
            }
            if (count($uri) >= 2) {
                $param = array_splice($uri, 2);
                // 额外的参数给_GET;
                foreach ($param as $k => $v) {
                    if (isset($param[$k + 1]) && !is_numeric($v)) {
                        $_GET[$v] = $param[$k + 1];
                        unset($param[$k + 1]);
                    } else
                        $_GET["param"] = $v;
                }
                self::$controller = $uri[0];
                self::$action = $uri[1];
            }
            if (count($uri) == 1) {
                self::$controller = $uri[0];
            }
        }
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
        return isset($_SERVER["argv"]) ? array_splice($_SERVER["argv"], 1) : array();
    }

    static function registerModule($_)
    {
        $args = func_get_args();
        foreach ($args as $value) {
            if (!in_array($value, self::$modules)) {
                self::$modules[] = $value;
            }
        }
    }
}