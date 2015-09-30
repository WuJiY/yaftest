<?php

class IndexController extends Base_IndexController
{
    private $server = '127.0.0.1';
    private $port = 1288;

    private $charset = 'utf-8';

    public function indexAction()
    {
        phpinfo();
        die;
        echo '前台';
    }

    /**
     * 入队列
     */
    public function setHttpsqsAction()
    {

        $handle = new Lib_Httpsqs('127.0.0.1', 1280);
        $handle->setAuth('auth');
        var_dump($handle->writeQs('qsTest', array("name" => 'zhangsa1n', 333)));
        die;
    }

    public function setHttpsqssAction()
    {

        $handle = new Lib_Httpsqs('127.0.0.1', 1280);
        $handle->setAuth('auth');
        var_dump($handle->writeQs('qsTest', array("name" => 'zhangsan', 333)));
        die;
    }

    /**
     * 出队列
     */
    public function getHttpsqsAction()
    {
        $handle = new Lib_Httpsqs('127.0.0.1', 1280);
        $handle->setAuth('auth');
        var_dump($handle->readQs('qsTest'));
    }

    public function getStatusAction()
    {
        $handle = new Lib_Httpsqs('127.0.0.1', 1280);
        $handle->setAuth('auth');
        var_dump($handle->getStatusJson('qsTest'));
    }

    public function testAction()
    {
        $use_obj = new UserModel();
        $use_obj->getAll();
        Yaf_Dispatcher::getInstance()->disableView();
    }
    public function infoAction()
    {
        phpinfo();
        die;
    }
}