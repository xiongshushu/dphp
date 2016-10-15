<?php

class model
{
    /**
     * @var \db\pdo
     */
    private $driver;

    public function __construct()
    {
        $this->driver = app::in("db");
    }

    public function __call($name, $args)
    {
        if (empty($this->driver)) {
            error::panic("driver missed!");
        }
        if (method_exists($this->driver, $name)) {
            return call_user_func_array(array($this->driver, $name), $args);
        }
        return FALSE;
    }

    public function query($sql, $data = array())
    {
        return $this->driver->query($sql, $data);
    }

    public function paging($params, $page = 1, $perPage = 10)
    {
        $data = array(
            "list" => array(),
            "page" => $page,
            "total" => 0,
            "totalPage" => 0,
            "perPage" => $perPage,
            "currentPage" => $page,
        );
        $params["fields"] = !empty($params["fields"]) ? $params["fields"] : "*";
        $params["where"] = !empty($params["where"]) ? " WHERE " . $params["where"] : " ";
        $params["values"] = !empty($params["values"]) ? $params["values"] : array();
        $params["order"] = !empty($params["order"]) ? " ORDER BY " . $params["order"] : " ";
        $condition = $this->table . $params["where"] . $params["order"];
        $countSql = "SELECT COUNT(1) AS Total FROM " . $condition;
        $total = $this->query($countSql, $params["values"])->fetch();
        if (!empty($total)) {
            $data["total"] = $total["Total"];
            $data["totalPage"] = ceil($total["Total"] / $perPage);
        }
        //取数据库数据
        $listSql = "SELECT " . $params["fields"] . " FROM " . $condition . " LIMIT " . ($page - 1) * $perPage . "," . $perPage;
        $data["list"] = $this->query($listSql, $params["values"])->fetchAll();
        return $data;
    }

    public function pageHtml($params, $page = 1, $perPage = 10)
    {
        $data = $this->paging($params, $page, $perPage);
        $data["firstPage"] = 1;
        $data["lastPage"] = 1;
        $data["nextPage"] = 1;
        $data["upPage"] = 1;
        $html = "";
        $pageLink = empty($params["pageLink"]) ? '' : "&" . $params["pageLink"];
        // 上一页
        if ($data["currentPage"] > 1) {
            $data["upPage"] = $data["currentPage"] - 1;
            $html .= "<li><a id=\"pre\" href=\"?p=" . $data["upPage"] . $pageLink . "\">上一页</a></li> ";
        }
        // 中间页码
        if ($data["totalPage"] > 1) {
            $begin = $data["page"] >= 10 ? $data["page"] - 4 : 1;
            $end = $data["totalPage"] - $begin >= 10 ? $begin + 9 : $data["totalPage"];
            for ($i = $begin; $i <= $end; $i++) {
                if ($i == $data["currentPage"]) {
                    $html .= "<li class=\"active\"><a href=\"?p=" . $data["currentPage"] . "\">$i</a></li> ";
                } else {
                    $html .= "<li><a href=\"?p=" . $i . $pageLink . "\">$i</a></li> ";
                }
            }
        }
        // 下一页
        if ($data["currentPage"] < $data["totalPage"]) {
            $data["nextPage"] = $data["currentPage"] + 1;
            $html .= "<li><a id=\"next\" href=\"?p=" . $data["nextPage"] . $pageLink . "\">下一页</a></li> ";
        }
        return array("list" => $data["list"], "html" => $html);
    }
}