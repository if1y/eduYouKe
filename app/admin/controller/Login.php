<?php
namespace app\admin\controller;
use app\AdminBaseController;
use think\facade\View;

class Login extends AdminBaseController
{
	//登录
    public function login()
    {
        return View::fetch('');
    }

    // 退出登录
    public function logout()
    {
        return View::fetch('');
    }


}
