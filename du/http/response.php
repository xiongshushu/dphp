<?php
namespace http;

class response
{
    static $error = "/assets/error.html";

    static $success = "/assets/success.html";

    static function success($msg, $url = "", $time = 5)
    {
        exit( include_once dirname(__DIR__) . self::$success );
    }

    static function error($msg, $url = "", $time = 5)
    {
        exit( include_once dirname(__DIR__) . self::$error );
    }

    static function json(array $data)
    {
        header("Content-Type:application/json;charset:utf-8");
        exit( json_encode($data, true) );
    }
}