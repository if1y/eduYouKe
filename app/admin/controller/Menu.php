<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\AdminMenu;
use think\facade\View;

class Menu extends AdminBaseController
{

    /**
     * [menulist 目录列表]
     * @return [type] [description]
     */
    public function menulist()
    {

        $menu = new AdminMenu();
        View::assign('menulist', $menu->getMenuList());
        return View::fetch();
    }

    //添加页面
    public function add()
    {
        $menu = new AdminMenu();
        View::assign('menulist', $menu->getMenuList());
        return View::fetch();
    }

    /**
     * [AddPost 提交数据]
     */
    public function AddPost()
    {
        $param = $this->request->param();
        $menu = new AdminMenu();
        $data = [
            'parent_id'=>$param['parent_id'],
            'type'=>$param['menuType'],
            'title'=>$param['title'],
            'url'=>trim($param['url']),
            'icon'=>!empty($param['icon']) ? trim($param['icon']) :'circle',
            'remark'=>$param['remark'],
            'show_status'=> !empty($param['show_status']) ? 1 :0
        ];
        $menu->save($data);

    }

    /**
     * [adminUserList 管理员列表]
     * @return [type] [description]
     */
    public function adminUserList()
    {
        return View::fetch();

    }

}
