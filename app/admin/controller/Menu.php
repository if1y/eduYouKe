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
    public function addPost()
    {
        $param = $this->request->param();
        $menu  = new AdminMenu();
        $data  = [
            'parent_id' => $param['parent_id'],
            'type' => $param['menuType'],
            'title' => $param['title'],
            'url' => trim(strtolower($param['url'])),
            'icon' => !empty($param['icon']) ? trim($param['icon']) : 'circle',
            'remark' => $param['remark'],
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];
        $menu->save($data);

    }

    /**
     * [edit 编辑展示页面]
     * @return [type] [description]
     */
    public function edit()
    {
        $param = $this->request->param();
        $menu  = new AdminMenu();
        View::assign('menulist', $menu->getMenuList());
        View::assign('editData', $menu->getAdminMenuInfo($param['id']));
        return View::fetch();
    }

    /**
     * [editPost 编辑提交]
     * @return [type] [description]
     */
    public function editPost()
    {
        $param = $this->request->param();

        $param['type']        = $param['menuType'];
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;
        $param['url'] = trim(strtolower($param['url']));
            
        $menu = new AdminMenu();
        $menuData = $menu->find($param['id']);
        $menuData->allowField([
            'parent_id',
            'type',
            'show_status',
            'title',
            'url',
            'icon',
            'remark',
        ])->save($param);

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
