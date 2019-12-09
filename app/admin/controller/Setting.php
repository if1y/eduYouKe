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

    public function slide()
    {
        return View::fetch('');
    }


    public function links()
    {
        return View::fetch('');
    }

    public function delete()
    {
        $param = $this->request->param();
        $data = ['name' => $param, 'code' => '1'];
        return json($data);
    }

    //
    public function add()
    {
        return View::fetch('');
        
    }

}
