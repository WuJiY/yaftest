<?php

/**
 * Class Db_Pdodriver
 *
 * select :
 *  $sql = "select * from `user`  where `id` = :id and `mobile`= :mobile";
 *  $this->db->query($sql, array(array(":id", "2398", 'int'), array(":mobile", '15319035838', 'string')));
 *
 * update/insert:
 *  $sql = "update `user` set `mobile`='15311312443' where id = :id";
 *  $this->db->exec($sql, array(array(":id", 2398, 'int')));
 *
 */
class Db_Pdodriver extends Db_Driver
{
    // 数据库配置
    protected $dbconf;
    // 数据库链接
    protected $connection;
    // pdostatement
    private $sth;
    // 预编译状态
    private $prepareActive = false;
    //绑定状态
    private $bindValActive = false;
    private static $_instance = null;
    private $options = array();
    // 错误
    private $errorinfo = array();

    private function __construct($config = array())
    {
        if (empty($config)) {
            $system_config = Yaf_Registry::get("Config");
            $config['hostname'] = $system_config['db']['hostname'];
            $config['dbname'] = $system_config['db']['dbname'];
            $config['username'] = $system_config['db']['username'];
            $config['pwd'] = $system_config['db']['passwd'];
            $config['charset'] = $system_config['db']['charset'];
        }
        $dsn = "mysql:host=" . $config['hostname'] . ';dbname=' . $config['dbname'];
        $this->dbconf = $config;
        try {
            $this->connection = new \PDO($dsn, $this->dbconf['username'], $this->dbconf['pwd'], $this->options);
            $this->connection->query("SET NAMES '{$this->dbconf['charset']}'");
        } catch (\PDOException $e) {
            $this->errLog($e);
        }
    }

    private function __clone()
    {
    }

    public static function getInstance($config = array())
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }

    // 选择数据库
    public function selectDb($dbname)
    {
        if (false === $this->exec('USE `' . $dbname . '`')) {
            return false;
        }
        $this->dbconf['dbname'] = $dbname;
        return true;
    }

    /**
     * 执行insert/update sql语句
     * 如果错误，返回false, 数据无变动，返回0， 有变动，返回变动条数
     */
    public function exec($sql, $bindVlaue)
    {
        // 预编译sql
        $this->sth = $this->connection->prepare($sql);
        if (false == $this->bindVal($bindVlaue)) {
            $this->errorinfo = $this->sth->errorInfo();
            return false;
        }
        // 执行sql语句 update/delete
        if (false == $this->sth->execute()) {
            $this->errorinfo = $this->sth->errorInfo();
            $this->sth->closeCursor();
            return false;
        }
        return $this->sth->rowCount();
    }



    /**
     *  执行sql查询语句
     * @param $sql
     * @param null $bindVlaue array(array(":id",123, 'int'), array(":name", "zhangsan", 'string'));
     * @return array|bool
     */
    public function query($sql, $bindVlaue = null)
    {
//          使用绑定的形式执行sql语句
        $this->sth = $this->connection->prepare($sql);
//          绑定数据
        if ($bindVlaue != null) {
            if (false == $this->bindVal($bindVlaue)) {
                $this->errorinfo = "绑定数据失败！";
                return false;
            }
        }
        if (false == $this->sth->execute()) {
            $this->errorinfo = $this->sth->errorInfo();
            $this->sth->closeCursor();
            return false;
        }
        $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);
        $this->sth->closeCursor();
        return $result;
    }

    /**
     * 执行绑定数据
     * @params array 数据，包括 index 键 value 值 type 类型
     */
    public function bindVal($params)
    {
        $offset = 1;
        while (!empty($params)) {
            $val = array_shift($params);
            if (!$this->sth->bindValue($offset++, $val)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 开启事务
     */
    public function transaction()
    {
        $this->connection->beginTransaction();
    }

    /**
     * 事务回滚
     */
    public function rollBack()
    {
        $this->connection->rollBack();
    }

    /**
     * 提交事务
     */
    public function commit()
    {
        $this->connection->commit();
    }

    public function getErrorinfo()
    {
        return $this->sth->errorinfo();
    }

    public function getDebugSql()
    {
        return $this->sth->debugDumpParams();
    }

    public function __destruct()
    {
        self::$_instance = null;
    }

}