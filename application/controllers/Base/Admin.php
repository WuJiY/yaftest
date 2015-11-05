<?php

class Base_AdminController extends Yaf_Controller_Abstract
{
    public function init()
    {
        $this->getMenu();
        Yaf_Controller_Abstract::getModuleName();
        die;
//        if (!Lib_Session::getInstance()->__get("uid")) {
//            $this->redirect("/Admin/public/login");
//        }
    }

    public function getMenu()
    {
        $nodeObj = new NodeModel();
        $all_node = $nodeObj->getAll();
        array_unshift($all_node, array(0));
        unset($all_node[0]);
        foreach ($this->nodeTree($all_node) as $value) {
            var_dump($value);die;
            if ($value['node_ename'] == Yaf_Controller_Abstract::getModuleName()) {
//                $this->getView()->assign("menuList", $value['chi']);
                break;
            }
        }
    }

    function nodeTree($items)
    {
        $tree = array();
        foreach ($items as $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['childen'][] = &$items[$item['id']];
            } else {
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

}