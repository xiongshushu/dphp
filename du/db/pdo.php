<?php
namespace du\db;

/**
 * PDO数据库驱动
 */
class pdo
{
    private $db;

    static $_instance;

    /**
     * 架构函数 数据库连接
     *
     * @access public
     */
    public function __construct($config = '')
    {
        try {
            $this->db = self::getInstance($config);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getInstance($config)
    {
        if (!self::$_instance instanceof self)
        {
            self::$_instance = new \PDO($config['dsn'], $config['db_user'], $config['db_pwd'], array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'' . $config['db_encode'] . '\''
            ));
            return self::$_instance;
        }
        return self::$_instance;
    }

    /**
     * 向数据库插入数据，返回受影响的行数
     * @param string $sql
     * @param array $data
     * @return mixed
     */
    public function add($sql, $data)
    {
        $this->query($sql, $data);
        return  $this->db->lastInsertId();
    }

    /**
     * 向数据库更新数据，返回布尔值
     * @param string $sql
     * @param array $data
     * @return mixed
     */
    public function update($sql, $data)
    {
        $result = $this->query($sql, $data);
        if ($result->errorCode()!== "00000")
        {
            return false;
        }
        return true;
    }

    /**
     * 向数据库查询数据，返回结果集
     * @param string $sql
     * @param array $data
     * @return mixed
     */
    public function findOne($sql, $data)
    {
        $result = $this->query($sql, $data);
        return $result->fetch();
    }

    /**
     * 向数据库查询数据，返回结果集
     * @param string $sql
     * @param array $data
     * @return mixed
     */
    public function find($sql, $data)
    {
        $result = $this->query($sql, $data);
        return $result->fetchAll();
    }

    /**
     * 删除数据，返回布尔值
     * @param string $sql
     * @param array $data
     * @return boolean
     */
    public function remove($sql, $data)
    {
        $result = $this->query($sql, $data);
        if ($result) {
            return true;
        }
        return false;
    }

    public function query($sql, $data)
    {
        try {
            $rst = $this->db->prepare($sql);
            foreach ($data as $key => &$value) {
               if (preg_match("/(_int)$/", $key) || is_numeric($key))
                {
                    $rst->bindParam($key,$value, \PDO::PARAM_INT);
                } else {
                    $rst->bindParam($key,$value, \PDO::PARAM_STR);
                }
            }
            $rst->setFetchMode(\PDO::FETCH_ASSOC);
            $rst->execute();

            $errorInfo = $rst->errorInfo();
            if ($errorInfo[2]) {
                $errInfo = $rst->errorInfo();
                throw new \Exception($errInfo[2]);
            }
            return $rst;
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 开始一个事务
     */
    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    /**
     * 事务提交
     */
    public function commit()
    {
        $this->db->commit();
    }

    /**
     * 事务回滚
     */
    public function rollBack()
    {
        $this->db->rollBack();
    }

    /**
     * 释放资源
     */
    public function __destruct()
    {
        $this->db = null;
    }
}