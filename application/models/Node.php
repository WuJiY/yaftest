<?php

/**
 * Created by PhpStorm.
 * User: dell
 * Date: 15-10-28
 * Time: 下午5:58
 */
class NodeModel extends Db_Basedb
{
    public $table_name = "User";

    public function getAll()
    {
        $sql = "select * from node";
        return $this->db->query($sql);
    }
}