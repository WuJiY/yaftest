<?php

class ErrorController extends Yaf_Controller_Abstract
{

    public function errorAction($exception)
    {
        // 设置404页面
        if (empty($message = $exception->getMessage())) {

        } else {
            // 处理异常
            echo json_encode(array('error' => 100, 'msg' => $message));
            die;
        }
    }
}