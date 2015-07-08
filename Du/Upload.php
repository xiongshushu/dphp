<?php
namespace Du;

class Upload
{

    /**
     * 表单文件提交的名称
     * @var string
     */
    public $input_name = "upload";

    /**
     * 文件名
     *
     * @var string
     */
    public $auto_name = TRUE;

    /**
     * 上传的文件名前缀
     *
     * @var string
     */
    public $file_prefix = "upload_";

    /**
     * 相对站点的路径
     *
     * @var string
     */
    public $file_save_dir = "/Upload";

    /**
     * 允许的文件扩展名
     *
     * @var string
     */
    public $file_Ext = "*";

    /**
     * 是否覆盖相同文件
     *
     * @var string
     */
    public $is_cover_file = TRUE;

    /**
     * 上传文件大小限制
     *
     * @var string
     */
    public $file_size = 2048000;

    /**
     * 错误消息
     * @var string
     */
    public $errorMsg ='';

    /**
     * 上传结果
     * @var string
     */
    public $result;

    public function save()
    {
        if ($this->checkExt() || $this->checkSize()) {
            $save_dir = $this->file_save_dir;
            $storageDir = date("/Ymd/", $_SERVER['REQUEST_TIME']);
            if (!is_dir($save_dir.$storageDir)){
                mkdir($save_dir.$storageDir,0777,true);
            }
            if ($this->auto_name) {
                $upfile = $this->file_prefix . uniqid() . "." . $this->getExt();
            }else {
                $upfile = $_FILES[$this->input_name]['name'];
            }
            $file = $save_dir . $storageDir .  $upfile;
            if (move_uploaded_file($_FILES[$this->input_name]['tmp_name'], $file)) {
                $this->result['file'] = $storageDir . $upfile;
                $this->result['status'] = true;
            }
            return $this->result;
        }
        $this->errorMsg = "文件校验失败！";
        return false;
    }

    private function checkExt()
    {
        if ($this->file_Ext == "*") {
            return true;
        }
        $ext = $this->getExt();
        if (! in_array(strtolower($ext), explode(",", strtolower($this->file_Ext)))) {
            $this->errorMsg = "上传文件不合法！";
            return false;
        }
        return true;
    }

    private function getExt()
    {
        if (isset($_FILES[$this->input_name])){
            $ext = pathinfo($_FILES[$this->input_name]['name']);
            return $ext['extension'];
        }
        return false;
    }

    private function checkSize()
    {
        if (isset($_FILES[$this->input_name])){
            $size = $_FILES[$this->input_name]['size'];
            if ($size > $this->file_size) {
                $this->errorMsg = "上传文件大小超过限制！";
                return false;
            }
           return true;
        }
        return false;
    }
}