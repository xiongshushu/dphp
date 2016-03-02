<?php
namespace du\form;

use du\Error;

class Form
{
    public function input($key = "")
    {
        $form = __MODULE__ . "\\Forms\\" . __CONTROLLER__;
        if (!class_exists($form)) {
            throw new Error("Couldn't find form : " . $form);
        }
        if (!method_exists($form, __ACTION__)) {
            throw new Error("Couldn't find  method : " . __ACTION__ . " of " . $form);
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
}
