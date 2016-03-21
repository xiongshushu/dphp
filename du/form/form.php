<?php
namespace du\form;

use du\error;

class form
{
    public function input($key = "")
    {
        $form = __MODULE__ . "\\forms\\" . __CONTROLLER__;
        if (!class_exists($form)) {
            throw new error("couldn't find form : " . $form);
        }
        if (!method_exists($form, __ACTION__)) {
            throw new error("couldn't find  method : " . __ACTION__ . " of " . $form);
        }
        $data = (new $form())->{__ACTION__}();
        $data = $this->removeXSS($data);
        return empty($key) ? $data : (empty($data[$key]) ? "" : $data[$key]);
    }

    public function removeXSS(array $data)
    {
        foreach ($data as $k => $v) {
            if (is_array($v)) {

                $this->removeXSS($v);
            } else {
                $data[$k] = htmlspecialchars(trim($v));
            }
        }
        return $data;
    }

    static function post($key = "")
    {
        if (empty($key)) {
            return (new self)->removeXSS($_POST);
        }
        return empty($_POST[$key]) ? "" : (new self)->removeXSS($_POST[$key]);
    }

    static function get($key = "")
    {
        if (empty($key)) {
            return (new self)->removeXSS($_GET);
        }
        return empty($_GET[$key]) ? "" : (new self)->removeXSS($_GET[$key]);
    }
}
