<?php
namespace Du;

class Form
{
    public function isEmpty($data, $msg)
    {
        if (empty($data)) {
            throw new FormError($msg);
        }
        return $data;
    }

    public function length($val, $max, $min = 0, $msg)
    {
        $len = mb_strlen($val);
        if ($len < $min || $len > $max) {
            throw new FormError($msg);
        }
        return $val;
    }

    public function size($val, $max, $min = 0, $msg)
    {
        if ($val < $min || $val > $max) {
            throw new FormError($msg);
        }
        return $val;
    }

    public function compare($val1, $val2, $msg)
    {
        if ($val1 != $val2) {
            throw new FormError($msg);
        }
        return $val1;
    }

    public function match($subject, $pattern, $msg)
    {
        if (!preg_match($pattern, $subject)) {
            throw new FormError($msg);
        }
        return $subject;
    }

    public function replace($val, $replace)
    {
        return empty($val) ? $replace : $val;
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

    public function input($key = "")
    {
        $form = __MODULE__ . "\\Middleware\\" . __CONTROLLER__;
        if (!class_exists($form)) {
            throw new Error("Couldn't find middleware: " . $form);
        }
        if (!method_exists($form, __ACTION__)) {
            throw new Error("Couldn't find  method : " . __ACTION__ . " of " . $form);
        }
        $call = new $form(DI::$di);
        $method = __ACTION__;
        $input = $this->parseInput($call->$method());
        return empty($key) ? $input : (empty($input[$key]) ? "" : $input[$key]);
    }

    public function parseInput($data)
    {
        if (empty($data) && $data != 0) {
            return [];
        }
        $data = $this->removeXSS($data);
        if (!is_array($data)) {
            return $data;
        }
        return $data;

    }

    public function removeXSS($val)
    {
        if (!is_array($val)) {
            return htmlspecialchars(trim($val));
        }
        foreach ($val as $k => $v) {
            if (is_array($v)) {
                $this->removeXSS($v);
            } else {
                $val[$k] = htmlspecialchars(trim($v));
            }
        }
        return $val;
    }

    public function __get($name)
    {
        return DI::$di->$name;
    }
}
