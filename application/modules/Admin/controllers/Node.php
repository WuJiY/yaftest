<?php

class NodeController extends Base_AdminController
{
    public function indexAction()
    {
        $nodeObj = new NodeModel();
        $node_list = $nodeObj->getAll();
        $this->getView()->assign('node', $node_list);
    }

    public function ableAction()
    {
        if (($id = intval($this->getRequest()->getPost("id"))) > 0) {
            $node_obj = new NodeModel();
            if (!empty($node_obj->getByPid($id))) {
                echo json_encode(array('error' => 100, 'msg' => '该节点下有子节点，不允许删除'));
            } else {
                if ($node_obj->deleteById($id, intval($this->getRequest()->getPost('able'))) == false) {
                    echo json_encode(array('error' => 100, 'msg' => '系统错误，请重试'));
                } else {
                    echo json_encode(array('error' => 200, 'msg' => '操作成功'));
                }
            }
        }
        die;
    }

    public function addAction()
    {
        $nodeObj = new NodeModel();
        if ($id = $this->getRequest()->get("id")) {
            if (!is_numeric($id)) {
                header("location:/admin/index/index");
            } else {
                if (!$nodeRow = $nodeObj->getByid($id)) {
                    // 显示错误
                } else {
                    // 赋值模板
                    $this->getView()->assign("id", $id);
                    $this->getView()->assign("nodeRow", $nodeRow[0]);
                }
            }
        }

        $node = array();
        foreach ($nodeObj->getAll() as $k1 => $v1) {
            $node[$k1 + 1] = $v1;
        }
        $this->getView()->assign("node", $this->nodeTree($node));
    }

    public function insertAction()
    {
        $param = array();
        try {
            // 更新
            if (intval($id = $this->getRequest()->getPost('id')) > 0) {
                echo '1';
                if (empty($param['node_ename'] = $this->getRequest()->getPost('ename'))) {
                    throw new \Exception("英文名必须填写");
                }
                echo '2';
                if (empty($param['node_name'] = $this->getRequest()->getPost('zname'))) {
                    throw new \Exception("中文名必须填写");
                }
                echo '3';
                var_dump($this->getRequest()->getPost('belong'));die;
                if (empty($param['pid'] = $this->getRequest()->getPost('belong'))) {
                    throw new \Exception("请选择所属节点");
                }
                echo '4';
                if (empty($param['status'] = $this->getRequest()->getPost('status'))) {
                    throw new \Exception("请选择所属节点");
                }
                echo '5';
                if ($param['pid'] == $id) {
                    throw new \Exception("节点添加错误");
                }
                echo '6';
                $param['update_time'] = date("Y-m-d H:i:s");
                $nodeObj = new NodeModel();
                $nodeObj->updateById($id, $param);
            } else {
                // insert
                if (empty($ename = $this->getRequest()->getPost('ename'))) {
                    throw new \Exception("英文名必须填写");
                }
                if (empty($zname = $this->getRequest()->getPost('zname'))) {
                    throw new \Exception("中文名必须填写");
                }
                if (empty($pid = $this->getRequest()->getPost('belong'))) {
                    throw new \Exception("请选择所属节点");
                }
                $nodeObj = new NodeModel();
                $nodeObj->insert();

            }
        } catch (\Exception $e) {
            echo json_encode(array("error" => 100, 'msg' => $e->getMessage()));
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