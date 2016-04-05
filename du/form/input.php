<?php
namespace form;

class input
{
    private function removeXSS($data)
    {
        if (!is_array($data)) {
            return htmlspecialchars(trim($data));
        }
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

    public function check($key, $method, $args)
    {
        unset($_GET["_s"]);
        $formData = array_merge($_GET, $_POST);
        if (isset($formData[$key])) {
            switch ($method) {
                case "empty":
                    if (empty($formData[$key])) {
                        throw new formError($args["msg"]);
                    }
                    break;
                case "len":
                    if (!($formData[$key]<=$args["max"] && $formData[$key]>=$args["min"])) {
                        throw new formError($args["msg"]);
                    }
                    break;
                case "size":
                    if ($formData[$key] < $args["min"] || $formData[$key] > $args["max"]) {
                        throw new formError($args["msg"]);
                    }
                    break;
                case "compare":
                    if ($args["value1"] != $args["value2"]) {
                        throw new formError($args["msg"]);
                    }
                    break;
                case "match":
                    if (!preg_match($args["pattern"], $formData[$key])) {
                        throw new formError($args["msg"]);
                    }
                    break;
                case "replace":
                    if (empty($formData[$key])) {
                        $formData[$key] = $args["replacer"];
                    }
                    break;
                default:
                    break;
            }
            return empty($formData[$key]) ? $this->removeXSS($formData) : $this->removeXSS($formData[$key]);
        }
        return "";
    }
}
