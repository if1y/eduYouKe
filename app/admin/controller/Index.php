<?php
namespace app\admin\controller;
use app\AdminBaseController;
use think\facade\View;
use app\logic\Index as indexLogic;


class Index extends AdminBaseController
{
    public function index()
    {
        $index = new indexLogic();
        //获取基础信息
         return view('',[
            'basecount'=>$index->getAdminCount(),
        ]);
    }

    public function hello()
    {
        return View::fetch();
    }
}
