<?php
namespace Du\Form;

use Du\DI\Injectable;
use Du\FormError;

class Validator extends Injectable {

    public $formData = array();

    public function __construct()
    {
        $this->formData = $_REQUEST;
        unset($this->formData["_s"]);
    }

    public function isEmpty($key, $msg)
    {
        if (empty($this->formData[$key])) {
            throw new FormError($msg);
        }
    }

    public function length($key, $max, $min = 0, $msg)
    {
        $len = mb_strlen($this->formData[$key]);
        if ($len < $min || $len > $max) {
            throw new FormError($msg);
        }
    }

    public function contrast($key, $msg, $max, $min = 0)
    {
        if ($this->formData[$key] < $min || $this->formData[$key] > $max) {
            throw new FormError($msg);
        }
    }

    public function compare($key1, $key2, $msg)
    {
        if ($this->formData[$key1] != $this->formData[$key2]) {
            throw new FormError($msg);
        }
    }

    public function match($key, $pattern, $msg)
    {
        if (!preg_match($pattern, $this->formData[$key])) {
            throw new FormError($msg);
        }
    }

    public function emptyReplace($key, $replace)
    {
        if (empty($this->formData[$key])) {
            $this->formData[$key] = $replace;
        }
    }

    public function post($key = "")
    {
        if (empty($key)) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : '';
    }

    public function get($key = "")
    {
        if (empty($key)) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : '';
    }
}