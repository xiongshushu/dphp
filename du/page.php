<?php

class page
{
    static $options = array(
        "page" => 1,
        "total" => "",
        "totalPage" => "",
        "perPage" => 10,
        "currentPage" => 1,
        "firstPage" => 1,
        "lastPage" => 1,
        "nextPage" => 1,
        "upPage" => 1,
    );

    static $html;

    static function mark($total, $perPage = 10, $page = 1, $pageLink = "")
    {
        self::$options["total"] = $total;
        self::$options["page"] = $page;
        self::$options["currentPage"] = $page;
        self::$options["totalPage"] = ceil($total / $perPage);
        self::$options["perPage"] = $perPage;
        self::$html = "";
        $pageLink = empty($pageLink) ? '' : "&" . $pageLink;
        // 上一页
        if (self::$options["currentPage"] > 1) {
            self::$options["upPage"] = self::$options["currentPage"] - 1;
            self::$html .= "<li><a id=\"pre\" href=\"?p=" . self::$options["upPage"] . $pageLink . "\">上一页</a></li> ";
        }
        // 中间页码
        if (self::$options["totalPage"] > 1) {
            $begin = self::$options["page"] >= 10 ? self::$options["page"] - 4 : 1;
            $end = self::$options["totalPage"] >= 10 ? $begin + 9 : self::$options["totalPage"];
            for ($i = $begin; $i <= $end; $i++) {
                if ($i == self::$options["currentPage"]) {
                    self::$html .= "<li class=\"active\"><a href=\"?p=" . self::$options["currentPage"] . "\">$i</a></li> ";
                } else {
                    self::$html .= "<li><a href=\"?p=" . $i . $pageLink . "\">$i</a></li> ";
                }
            }
        }
        // 下一页
        if (self::$options["currentPage"] < self::$options["totalPage"]) {
            self::$options["nextPage"] = self::$options["currentPage"] + 1;
            self::$html .= "<li><a id=\"next\" href=\"?p=" . self::$options["nextPage"] . $pageLink . "\">下一页</a></li> ";
        }
        return self::$html;
    }
}