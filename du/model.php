<?php
namespace du;

use du\di\injectable;

class model extends injectable
{
    public function __call($name, $args)
    {
        $db = $this->db;
        if (empty($db)) {
            throw new Error("you must register an Db!");
        }
        if (method_exists($this->db, $name)) {
            return call_user_func_array(array($this->db, $name), $args);
        }
        return FALSE;
    }
}