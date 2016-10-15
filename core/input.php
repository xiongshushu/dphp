<?php

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
        $result = false;
        if (isset($formData[$key])) {
            switch ($method) {
                case "empty":
                    $result = !empty($formData[$key]);
                    break;
                case "len":
                    $result = $formData[$key] <= $args["max"] && $formData[$key] >= $args["min"];
                    break;
                case "size":
                    $result = $formData[$key] < $args["min"] || $formData[$key] > $args["max"];
                    break;
                case "compare":
                    $result = $args["value1"] == $args["value2"];
                    break;
                case "match":
                    $result = preg_match($args["pattern"], $formData[$key]);
                    break;
                default:
                    $result = empty($formData[$key]);
                    break;
            }
        }
        if ($result == false) {
            throw new \Exception($args["msg"]);
        }
        return empty($formData[$key]) ? $this->removeXSS($formData) : $this->removeXSS($formData[$key]);
    }
}
