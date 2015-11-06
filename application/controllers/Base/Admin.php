<?php

class Base_AdminController extends Yaf_Controller_Abstract
{
    public function init()
    {
        $this->getMenu();
//        if (!Lib_Session::getInstance()->__get("uid")) {
//            $this->redirect("/Admin/public/login");
//        }
    }

    public function getMenu()
    {
        $nodeObj = new NodeModel();
        $nodeTree = $this->nodeTree($nodeObj->getAll());
        foreach ($nodeTree as $value) {
            if ($value['node_ename'] == Yaf_Controller_Abstract::getModuleName()) {
                $this->getView()->assign("menuList", $value['childen']);
                break;
            }
        }
    }
    function nodeTree($node, $access = null, $pid = 0)
    {
        $arr = array();
        foreach ($node as $v) {
            if (is_array($access)) {
                $v['access'] = in_array($v['id'], $access) ? 1 : 0;
            }
            if ($v['pid'] == $pid) {
                $v['childen'] = $this->nodeTree($node, $access, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }
}