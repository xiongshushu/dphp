<?php
namespace storage;

class log
{
    public $logPath;

    public $logFileSize = 2048000;

    public function write($log,$destination='') {
        if(empty($destination)){
            $destination = $this->logPath.date('Y_m_d').'.log';
        }
        // 自动创建日志目录
        $log_dir = dirname($destination);
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if(is_file($destination) && floor($this->logFileSize) <= filesize($destination) ){
            rename($destination,dirname($destination).'/'.time().'-'.basename($destination));
        }
        error_log("[".date("Y-m-d H:i:s")."] {$log}\r\n", 3,$destination);
    }
}