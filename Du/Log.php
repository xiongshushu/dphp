<?php
namespace Du;

class Log
{
    public $log_time_format;

    public $log_path;

    public $log_file_size = 2048000;

    public function write($log,$destination='') {
        $now = date($this->log_time_format);
        if(empty($destination)){
            $destination = $this->log_path.date('Y_m_d').'.log';
        }
        // 自动创建日志目录
        $log_dir = dirname($destination);
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if(is_file($destination) && floor($this->log_file_size) <= filesize($destination) ){
            rename($destination,dirname($destination).'/'.time().'-'.basename($destination));
        }
        $addr = "localhost:cli";
        if (php_sapi_name()!="cli")
        {
            $addr = $_SERVER['REMOTE_ADDR'].$_SERVER['REQUEST_URI'];
        }
        error_log("[{$now}] ".$addr."\r\n{$log}\r\n", 3,$destination);
    }
}