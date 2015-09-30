<?php

class PublicController extends Yaf_Controller_Abstract
{
    public function loginAction()
    {
        $this->getView()->assign("record", "name");
    }

    public function checkloginAction()
    {
        try {
            if (!($this->getRequest()->getPost("validate", 0) == Lib_Session::getInstance()->__get("validate"))) {
                throw new Exception('验证码错误！');
            }
            if (empty($this->getRequest()->getPost("username")) || empty($this->getRequest()->getPost("password"))) {
                throw new Exception("请填写用户名和密码!");
            }
            $user_obj = new UserModel();
            $user_obj->getAll();
        } catch (Exception $e) {
            echo json_encode(array("return_status" => 100, "msg" => $e->getMessage()));
        }
        Yaf_Dispathcer::getInstance()->disableView();
    }
}