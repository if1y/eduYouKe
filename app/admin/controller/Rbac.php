<?php
namespace app\admin\controller;
use app\AdminBaseController;
use think\facade\View;


class Rbac extends AdminBaseController
{

    /**
     * [AdminUserList 管理员列表]
     */
    public function RbacList()
    {
        return View::fetch();
    }

    /**
     * [add 添加管理员]
     */
    public function add()
    {
        return View::fetch();
    }



}
