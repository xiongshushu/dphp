<?php
namespace http;

trait request
{
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