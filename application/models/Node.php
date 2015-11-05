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

    public function insert($params)
    {
        $this->db->insert($this->table_name, $params);
//        if (empty($params))
//            return false;
//        $tmp = array();
//        $key = $val = '';
//        foreach ($params as $k1 => $v1) {
//            $key .= "`" . $k1 . "`,";
//            $val .= "?,";
//            $tmp[] = $v1;
//        }
//        $sql = "insert into " . $this->table_name . " (" . rtrim($key, ',') . ") values (" . rtrim($val, ',') . ")";
//        return $this->db->exec($sql, $tmp);
    }



    public function getAll()
    {
        $sql = "select * from node";
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