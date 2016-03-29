<?php

class model
{
    public $sql = "";

    public $data = array();

    public $db;

    public function __construct()
    {
        $this->db = di::invoke("db");
    }

    /**
     * 调用pdo类库操作
     * @param $name
     * @param $args
     * @return bool|mixed
     * @throws Error
     */
    public function __call($name, $args)
    {
        $db = $this->db;
        if (empty($db)) {
            throw new Error("driver missed!");
        }
        if (method_exists($this->db, $name)) {
            return call_user_func_array(array($this->db, $name), $args);
        }
        return FALSE;
    }
}