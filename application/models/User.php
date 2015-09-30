<?php

class UserModel extends Db_Basedb
{
    public $table_name = "User";

    public function getAll()
    {
        //update
        $sql = "update `user` set `mobile`='15311312443' where id = :id";
        var_dump($this->db->exec($sql, array(array(":id", 2398, 'int'))));


        //select

//
//        $sql = "select * from `user`  where `id` = :id and `mobile`= :mobile";
////        $sql = "select * from `user`  where `id` = 2 ";
////        $sql = "update `user` set `mobile`='15311311442' where id = :id";
//        var_dump($this->db->query($sql, array(array(":id", "2398", 'int'), array(":mobile", '15319035838', 'string'))));
////        var_dump($this->db->query($sql));
////        var_dump($this->db->getDebugSql());
//        var_dump($this->db->getErrorinfo());
    }
}