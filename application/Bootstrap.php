<?php


class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public function _initConfig()
    {
        Yaf_Registry::set("Config", Yaf_Application::app()->getConfig()->toArray());


    }

    /**
     * 启用异常,404页面在此处
     */
    public function _initEnablecatch()
    {
//        Yaf_Dispatcher::getInstance()->catchException(true);
    }
}