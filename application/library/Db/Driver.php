<?php
//namespace Db;

//use Db;

abstract class Db_Driver
{
    // 数据库配置
    protected $dbconf;
    // 数据库链接
    protected $connection;

    // 选择数据表
    abstract protected function selectDb($dbname);

    // 执行查询语句
    abstract protected function query($sql, $bindValue = '');

    // 执行写入/更新语句
    abstract protected function exec($sql, $bindValue);


    // 异常处理
    protected function errLog($e)
    {
        if (isset($this->dbconf['db_debug']) && $this->dbconf['db_debug']) {
            die($e->getMessage());
        } else {
            die($e->getMessage());
        }
    }
}