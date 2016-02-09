<?php
namespace Du;

class Page
{

    public $page = 1;

    public $total;

    public $totalPage;

    public $epage = 10;

    public $currentPage = 1;

    public $firstPage = 1;

    public $lastPage = 1;

    public $nextPage = 1;

    public $upPage = 1;

    /**
     * 总页数，总条数,最后一页
     * @param int $num
     * 总条数
     */
    public function calc($num, $p = 1)
    {
        $this->totalPage = ceil($num / $this->epage);
        $this->total = $num;
        $this->page = $p;
        $this->currentPage = $p;
        $this->lastPage = $this->totalPage;
    }

    /**
     * 默认输出html的分页
     * @param string $pageLink 需要追加到链接后的get参数
     * @param bool $html 输出形式true：html代码，false：分页参数数据
     * @return mixed
     */
    public function build($pageLink = '', $html = true)
    {
        $page = "";
        $pageLink = empty($pageLink) ? '' : "&" . $pageLink;
        // 上一页
        if ($this->currentPage > 1) {
            $this->upPage = $this->currentPage - 1;
            $page .= "<li><a id=\"pre\" href=\"?p=" . $this->upPage . $pageLink . "\">上一页</a></li> ";
        }
        // 中间页码
        if ($this->totalPage > 1) {
            $begin = $this->page >= 10 ? $this->page - 4 : 1;
            $end = $this->totalPage >= 10 ? $begin + 9 : $this->totalPage;
            for ($i = $begin; $i <= $end; $i++) {
                if ($i == $this->currentPage) {
                    $page .= "<li class=\"active\"><a href=\"?p=" . $this->currentPage . "\">$i</a></li> ";
                } else {
                    $page .= "<li><a href=\"?p=" . $i . $pageLink . "\">$i</a></li> ";
                }
            }
        }
        // 下一页
        if ($this->currentPage < $this->totalPage) {
            $this->nextPage = $this->currentPage + 1;
            $page .= "<li><a id=\"next\" href=\"?p=" . $this->nextPage . $pageLink . "\">下一页</a></li> ";
        }
        return $type ? $page : array(
            "page" => $this->page,
            "epage" => $this->epage,
            "totalPage" => $this->totalPage,
            "total" => $this->total,
            "currentPage" => $this->currentPage,
            "nextPage" => $this->nextPage,
            "upPage" => $this->upPage,
        );
    }
}

?>