<?php

class error
{
    static function file($message, $dest = '')
    {
        if (empty($dest)) {
            $dest = LOG_PATH . date('Y_m_d') . '.log';
        }
        $log_dir = dirname($dest);
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        if (is_file($dest) && 2048000 <= filesize($dest)) {
            rename($dest, dirname($dest) . '/' . time() . '-' . basename($dest));
        }
        error_log("[" . date("Y-m-d H:i:s") . "] " . $_SERVER["REQUEST_URI"] . "\r\n {$message}\r\n", 3, $dest);
    }

    static function json($message)
    {
        header("Content-Type:application/json;charset:utf-8");
        exit(json_encode(array(
            "msg" => $message,
            "code" => 100,
            "flag" => false,
        )));
    }

    static function panic($message,Exception $previous = null)
    {
        throw new \Exception($message, 100, $previous);
    }

    static function make(callable $func, $type = "error::json")
    {
        try{
            return $func();
        }catch (\Exception $e){
            call_user_func($type,$e->getMessage());
        }
    }
}