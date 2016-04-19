<?php
namespace pagination;

class page
{

    public $options = array(
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

    public $html;

    public function __construct($total, $perPage = 10, $page = 1, $pageLink = "")
    {
        $this->options["total"] = $total;
        $this->options["page"] = $page;
        $this->options["currentPage"] = $page;
        $this->options["totalPage"] = ceil($total / $perPage);
        $this->options["perPage"] = $perPage;
        $this->html = "";
        $pageLink = empty($pageLink) ? '' : "&" . $pageLink;
        // 上一页
        if ($this->options["currentPage"] > 1) {
            $this->options["upPage"] = $this->options["currentPage"] - 1;
            $this->html .= "<li><a id=\"pre\" href=\"?p=" . $this->options["upPage"] . $pageLink . "\">上一页</a></li> ";
        }
        // 中间页码
        if ($this->options["totalPage"] > 1) {
            $begin = $this->options["page"] >= 10 ? $this->options["page"] - 4 : 1;
            $end = $this->options["totalPage"] >= 10 ? $begin + 9 : $this->options["totalPage"];
            for ($i = $begin; $i <= $end; $i++) {
                if ($i == $this->options["currentPage"]) {
                    $this->html .= "<li class=\"active\"><a href=\"?p=" . $this->options["currentPage"] . "\">$i</a></li> ";
                } else {
                    $this->html .= "<li><a href=\"?p=" . $i . $pageLink . "\">$i</a></li> ";
                }
            }
        }
        // 下一页
        if ($this->options["currentPage"] < $this->options["totalPage"]) {
            $this->options["nextPage"] = $this->options["currentPage"] + 1;
            $this->html .= "<li><a id=\"next\" href=\"?p=" . $this->options["nextPage"] . $pageLink . "\">下一页</a></li> ";
        }
    }
}