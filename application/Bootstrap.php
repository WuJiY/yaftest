<?php


class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public function _initConfig()
    {
        Yaf_Registry::set("Config", Yaf_Application::app()->getConfig()->toArray());
    }


}