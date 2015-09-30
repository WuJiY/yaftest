<?php

class Lib_Session
{
    public static $obj = null;
    public static $module = null;
    private static $session_content = null;
    //缓存生命周期10分钟
    private static $session_cache_expire = 10;

    private function __construct()
    {
        session_cache_expire(10);
        session_start();
    }

    public static function getInstance()
    {
        if (!(self::$obj instanceof self)) {
            self::$obj = new self;
        }
        return self::$obj;
    }

    /**
     * 设置session
     */
    public function __set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * 获取session数据
     */
    public function __get($key = null)
    {
        if ($key == null) {
            return $_SESSION;
        }
        return $_SESSION[$key];
    }

    /**
     * 删除session
     */
    public function __unset($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * 注销session
     */
    public function __destory()
    {
        unset($_SESSION);
        session_destroy();
    }
}