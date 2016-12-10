<?php

class http
{

    private static $handler = "";

    static function registerHandler($handler)
    {
        self::$handler = $handler;
    }

    static function json(array $data)
    {
        header("Content-Type:application/json;charset:utf-8");
        exit(json_encode($data, true));
    }

    static function error($code, $message = "")
    {
        switch ($code) {
            case 404:
                header("http/1.1 404 not found");
                break;
        }
        if (empty(self::$handler)) {
            echo $message;
            return true;
        }
        $handler = self::$handler;
        $handler($code, $message);
    }

    static function isPost()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return true;
        }
        return false;
    }

    static function isGet()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return true;
        }
        return false;
    }

    static function redirect($action = "")
    {
        header("location:" . $action);
    }
}