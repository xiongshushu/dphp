<?php

class e extends Exception
{
    static function panic($message = "", $code = 0, Exception $previous = null)
    {
        throw new self($message, $code, $previous);
    }

    /**
     * 记录日志
     * @param string $log
     * @param string $destination
     */
    static function log($log, $destination = '')
    {
        if (empty($destination)) {
            $destination = LOG_PATH . date('Y_m_d') . '.log';
        }
        // 自动创建日志目录
        $log_dir = dirname($destination);
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (is_file($destination) && 2048000 <= filesize($destination)) {
            rename($destination, dirname($destination) . '/' . time() . '-' . basename($destination));
        }
        error_log("[" . date("Y-m-d H:i:s") . "] ".$_SERVER["REQUEST_URI"]."\r\n {$log}\r\n", 3, $destination);
    }
}