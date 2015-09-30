<?php

/**
 * Class BaseModel
 * 数据库基类
 */
class BaseModel extends Db_Driver
{

    protected $db = null;
    public $table_name = NULL;
    private $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    public function __construct($config = null)
    {
        if ($this->db == null) {
            $config = $this->getDbConfig($config);
            $this->db = DbPdo::getInstance($config);
        }
    }

    /**
     * 获取db类配置
     */
    private function getDbConfig($config = null)
    {
        if ($config == null) {
            $config = Yaf_Registry::get("Config");
            $dsn = "mysql:host=" . $config['db']['hostname'] . ";dbname=" . $config['db']['dbname'];
            $username = $config['db']['username'];
            $pwd = $config['db']['pwd'];
        } else {
            $dsn = "mysql:host=" . $config['hostname'] . ";dbname=" . $config['dbname'];
            $username = $config['username'];
            $pwd = $config['pwd'];
        }
        $this->db = new \PDO($dsn, $username, $pwd, $this->options);
    }

    protected function query($sql, $params = null)
    {
        if (is_array($params) && !empty($params)) {
            foreach ($params as $key => $value) {
                $this->bindValue($key, $value);
            }
        }
    }

    private function bindValue($key, $value)
    {
//        $this->
    }

    protected function getLine()
    {

    }

    protected function exec()
    {

    }

    protected function insert($arr)
    {

    }

    protected function update($arr_where, $arr_set)
    {

    }

    private function quote()
    {

    }

}