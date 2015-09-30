<?php

class PublicController extends Yaf_Controller_Abstract
{
    public function varifyAction()
    {
        $img = Factory::Library('Lib_Imagevalidate');
        $img->doimg();
        Lib_Session::getInstance()->__set("validate", $img->getCode());
    }
}