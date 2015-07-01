<?php
namespace Du;

class Page
{

    public $page = 1;

    public $total;

    public $total_page;

    public $epage = 10;

    public $current_page = 1;

    public $first_page = 1;

    public $last_page = 1;

    public $next_page = 1;

    public $up_page = 1;

    /**
     * 总页数，总条数,最后一页
     *
     * @param int $num
     *            总条数
     */
    public function calc($num, $p = 1)
    {
        $this->total_page = ceil($num / $this->epage);
        $this->total = $num;
        $this->page = $p;
        $this->current_page = $p;
        $this->last_page = $this->total_page;
    }

    /**
     * 默认输出html的分页
     *
     * @param bool $html
     * @return mixed
     */
    public function build($pagelink = '')
    {
        $page = "";
        $pagelink = empty($pagelink)?'':"&".$pagelink;
        // 上一页
        if ($this->current_page > 1) {
            $this->up_page = $this->current_page - 1;
            $page .= "<li><a id=\"pre\" href=\"?p=" . $this->up_page . $pagelink. "\">上一页</a></li> ";
        }
        // 中间页码
        if ($this->total_page > 1) {
            $begin = $this->page>=10?$this->page-4:1;
            $end = $this->total_page>=10?$begin+9:$this->total_page;
            for ($i = $begin; $i <= $end; $i ++) {
                if ($i == $this->current_page) {
                    $page .= "<li class=\"active\"><a href=\"?p=" . $this->current_page .  "\">$i</a></li> ";
                }else {
                    $page .= "<li><a href=\"?p=" . $i . $pagelink . "\">$i</a></li> ";
                }
            }
        }
        // 下一页
        if ($this->current_page < $this->total_page) {
            $this->next_page = $this->current_page + 1;
            $page .= "<li><a id=\"next\" href=\"?p=" . $this->next_page . $pagelink . "\">下一页</a></li> ";
        }
        return array(
            "page" => $this->page,
            "epage" => $this->epage,
            "total_page" => $this->total_page,
            "total" => $this->total,
            "current_page" => $this->current_page,
            "next_page" => $this->next_page,
            "up_page" => $this->up_page,
            "pagehtml"=>$page,
        );
    }
}

?>