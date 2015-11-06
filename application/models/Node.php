<?php

/**
 * Created by PhpStorm.
 * User: dell
 * Date: 15-10-28
 * Time: 下午5:58
 */
class NodeModel extends Db_Basedb
{
    public $table_name = "node";
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;

    public static $STATUS_MAP = array(
        self::STATUS_ENABLE => '启用',
        self::STATUS_DISABLE => '禁用'
    );

    public function getAll()
    {
        $sql = "select * from node order by `sort` asc";
        return $this->db->query($sql);
    }

    public function getByPid($pid)
    {
        $sql = "select * from " . $this->table_name . ' where `pid`=? and `status`=?';
        return $this->db->query($sql, array($pid, self::STATUS_ENABLE));
    }

    public function deleteById($id, $status)
    {
        $sql = "update " . $this->table_name . " set `status`=? WHERE id=?";
        return $this->db->exec($sql, array($status, $id));
    }
}