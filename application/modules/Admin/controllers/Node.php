<?php

class NodeController extends Base_AdminController
{
    public function indexAction()
    {
        $nodeObj = new NodeModel();
        $node_list = $nodeObj->getAll();
        $this->getView()->assign('node', $node_list);
    }
}