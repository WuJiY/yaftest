<?php

/**
 * Class Lib_Ftp
 * ftp 操作类
 */
class Lib_Ftp
{
    private $connect;

    public function __construct($host)
    {
        if (!$this->connect = ftp_connect($host)) {
            throw new Exception("连接失败");
        }
    }

    public function getList($user = null, $passwd = null)
    {
        if ($user != null) {
            if (!@ftp_login($this->connect, $user, $passwd)) {
                throw new \Exception("登陆失败");
            }
        }
        $handle = fopen("/tmp/tex.txt", 'wb');
        $file_list = ftp_nlist($this->connect, '/');
        foreach ($file_list as $v) {
            if (ftp_get($this->connect, $handle, "/" . $v, FTP_BINARY, 0)) {
                echo 'succ';
            } else {
                echo 'fail';
            }
        }
        die;

        ftp_close($this->connect);
        fclose($handle);
//        var_dump(ftp_nlist($this->connect, '/'));
    }
}