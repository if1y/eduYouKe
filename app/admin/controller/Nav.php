<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\Nav as NavLogic;
use think\facade\View;

class Nav extends AdminBaseController
{

	public function index()
	{
		$nav = new NavLogic();
		return view('',['menulist'=>[]]);

	}

	public function add()
	{
		$nav = new NavLogic();
		return view('',['menulist'=>[]]);
	}

	public function edit()
	{
		$nav = new NavLogic();
		return view('',['menulist'=>[]]);
	}
}