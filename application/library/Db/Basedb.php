<?php
//namespace Database;
//
//use Database;

class Db_Basedb
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Db_Pdodriver::getInstance();
    }
}