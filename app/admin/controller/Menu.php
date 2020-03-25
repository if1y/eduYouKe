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
        $param = $this->request->param();

        $menu = new AdminMenu();
        if ($this->request->isPost())
        {
            if ($menu->addMenu($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->success('操做失败');
            }

        }
        else
        {

            View::assign('menulist', $menu->getMenuList());
            return View::fetch();
        }
    }

    /**
     * [edit 编辑展示页面]
     * @return [type] [description]
     */
    public function edit()
    {
        $param = $this->request->param();
        $menu  = new AdminMenu();

        if ($this->request->isPost())
        {

            if ($menu->editMenu($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->success('操做失败');
            }
        }
        else
        {

            return view('', [
                'menulist' => $menu->getMenuList(),
                'editData' => $menu->getAdminMenuInfo($param['id']),
                'actionCheck' => $menu->getActionCheck($menu->getAdminMenuInfo($param['id'])),
            ]);
        }
    }

    /**
     * [delete 删除操作]
     * @return [type] [description]
     */
    public function del()
    {
        $param  = $this->request->param();
        $menu   = new AdminMenu();
        $result = $menu->update(['delete_status' => 1], ['id' => $param['id']]);
        if ($result)
        {
            return json(['code' => 1, 'msg' => '删除成功']);
        }
        else
        {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

}
