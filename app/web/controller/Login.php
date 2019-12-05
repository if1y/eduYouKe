<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;

class Login extends WebBaseController
{
	//登录
    public function login()
    {
        return View::fetch('');
    }

    // 注册
    public function register()
    {
        return View::fetch('');
    }

    // 忘记密码
    public function forget()
    {
        return View::fetch('');
    }


    // 忘记密码
    public function logout()
    {
    	return redirect('/');
        // return View::fetch('');
    }


}
