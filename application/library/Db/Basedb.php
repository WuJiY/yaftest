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
            }
            echo $key;
            die;
        }
        return false;
    }

    public function insert()
    {

    }
}