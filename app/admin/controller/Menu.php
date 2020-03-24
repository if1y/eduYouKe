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
    public function index()
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
    public function addPost()
    {
        $param = $this->request->param();
        $menu  = new AdminMenu();
        $menu->addMenu($param);
    }

    /**
     * [edit 编辑展示页面]
     * @return [type] [description]
     */
    public function edit()
    {
        $param = $this->request->param();
        $menu  = new AdminMenu();
        // print_r($menu->getActionCheck($menu->getAdminMenuInfo($param['id'])));exit;
        return view('', [
            'menulist' => $menu->getMenuList(),
            'editData' => $menu->getAdminMenuInfo($param['id']),
            'actionCheck' => $menu->getActionCheck($menu->getAdminMenuInfo($param['id'])),
        ]);
    }

    /**
     * [editPost 编辑提交]
     * @return [type] [description]
     */
    public function editPost()
    {
        $param = $this->request->param();

        $menu = new AdminMenu();
        $menu->editMenu($param);

    }

    /**
     * [delete 删除操作]
     * @return [type] [description]
     */
    public function delete()
    {
        $param = $this->request->param();
        $menu = new AdminMenu();
        $result = $menu->update(['delete_status'=> 1],['id'=>$param['id']]);
        if ($result) {
            return json(['code'=>1,'msg'=>'删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'删除失败']);
        }
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
