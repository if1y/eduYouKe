<?php
namespace app\web\controller;

use app\WebBaseController;
use think\facade\View;

class User extends WebBaseController
{

	//用户中心
    public function centor()
    {
        return View::fetch();
    }

    //用户订单
    public function order()
    {
        return View::fetch();
    }


    //用户学习历史
    public function history()
    {
        return View::fetch();
    }

    //用户消息列表
    public function message()
    {
        return View::fetch();
    }

    public function avatarUpload()
    {

    	print_r($_FILES);exit();
        $param = $this->request->param();

    	print_r($param);exit();
    }

}
