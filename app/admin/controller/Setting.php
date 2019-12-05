<?php
namespace app\admin\controller;
use app\AdminBaseController;
use think\facade\View;

class Setting extends AdminBaseController
{
	//首页
    public function index()
    {
        return View::fetch('');
    }

    public function Login()
    {
        return View::fetch('');
    }

}
