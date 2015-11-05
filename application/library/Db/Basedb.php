<?php
//namespace Database;
//
//use Database;

class Db_Basedb
{
    protected $db = null;
    public $table_name = null;

    public function __construct()
    {
        $this->db = Db_Pdodriver::getInstance();
    }

    public function getByid($id)
    {
        if ($this->table_name == null) {
            return false;
        }
        $sql = "SELECT * FROM " . $this->table_name . " WHERE `id`=?";
        return $this->db->query($sql, array($id));
    }

    public function updateById($id, $params)
    {
        if (is_array($params) && !empty($params)) {
            $tmp = $key = $value = '';
            foreach ($params as $k => $v) {
                $key .= "`{$k}`=?,";
                $tmp[] = $v;
            }
            $sql = "update " . $this->table_name . " set $key where `id`=$id";
            return $this->db->exec($sql, $tmp);
        }
        return false;
    }

    /**
     * 新增数据
     * @param $params
     */
    public function insert($params)
    {
        if (is_array($params) && !empty($params)) {
            $tmp = array();
            $key = $val = '';
            foreach ($params as $k1 => $v1) {
                $key .= "`" . $k1 . "`,";
                $val .= "?,";
                $tmp[] = $v1;
            }
            $sql = "insert into " . $this->table_name . "(" . rtrim($key, ',') . ") values (" . rtrim($val, ',') . ")";
            return $this->db->exec($sql, $tmp);
        }
        return false;
    }
}