<?php

class IndexController extends Base_AdminController
{
    public function indexAction()
    {
        $this->getView()->assign("name","zhangsan");
    }
}