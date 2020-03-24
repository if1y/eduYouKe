<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\AdminRole as Role;
use app\logic\AdminUser;
use app\util\Tools;
use think\facade\View;

class Administrator extends AdminBaseController
{
    /**
     * [AdminUserList 管理员列表]
     */
    public function index()
    {
        $User = new AdminUser();
        $list = $User->getAdminUserList();
        View::assign('userlist', $list);
        View::assign('page', $list->render());
        return View::fetch();
    }

    /**
     * [add 添加管理员]
     */
    public function add()
    {
        $param = $this->request->param();

        //
        if ($this->request->isPost())
        {
            print_r($param);exit();
            $User = new AdminUser();

            $param['password']    = Tools::userMd5($param['password']);
            $param['show_status'] = isset($param['show_status']) ? $param['show_status'] : 0;

            if ($User->save($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->success('操做失败');
            }

            $User->save($data);

        }
        else
        {

            $role = new Role();
            View::assign('rolelist', $role->where('delete_status', 0)->select());
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
        $User  = new AdminUser();
        $role  = new Role();

        //
        if ($this->request->isPost())
        {

            $param['password']    = !empty($param['password']) ? Tools::userMd5($param['password']) : 0;
            $param['show_status'] = isset($param['show_status']) ? $param['show_status'] : 0;

            if (!$param['password'])
            {
                unset($param['password']);
            }
            if ($User->where('id',$param['id'])->save($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->success('操做失败');
            }

            // $userData = $User->find($param['id']);
            // $result   = $userData->allowField([
            //     'user_type',
            //     'nickname',
            //     'password',
            //     'mobile',
            //     'role_id',
            //     'avatar_url',
            //     'show_status',
            // ])->save($param);

        }
        else
        {

            View::assign('rolelist', $role->where('delete_status', 0)->select());
            View::assign('editData', $User->getAdminUserInfo($param['id']));
            return View::fetch();
        }
    }

    /**
     * [editPost 编辑提交]
     * @return [type] [description]
     */
    public function editPost()
    {
        $param = $this->request->param();

        $param['password']    = !empty($param['password']) ? Tools::userMd5($param['password']) : 0;
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;
        if (!$param['password'])
        {
            unset($param['password']);
        }

        $User     = new AdminUser();

        $userData = $User->find($param['id']);
        $result   = $userData->allowField([
            'user_type',
            'nickname',
            'password',
            'mobile',
            'role_id',
            'avatar_url',
            'show_status',
        ])->save($param);

    }

    /**
     * [delete 删除操作]
     * @return [type] [description]
     */
    public function del()
    {
        $param  = $this->request->param();
        $User   = new AdminUser();
        $result = $User->update(['delete_status' => 1], ['id' => $param['id']]);
        if ($result)
        {
            return json(['code' => 1, 'msg' => '删除成功']);
        }
        else
        {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }


    public function tree()
    {
        return View::fetch();
    }

    /**
     * [edit 编辑展示页面]
     * @return [type] [description]
     */
    public function editInfo()
    {
        $param = $this->request->param();
        $User  = new AdminUser();
        View::assign('editData', $User->getAdminUserInfo($param['id']));
        return View::fetch();
    }

    //
    public function editInfoPost()
    {

        $param = $this->request->param();

        $param['password'] = !empty($param['password']) ? Tools::userMd5($param['password']) : 0;
        if (!$param['password'])
        {
            unset($param['password']);}

        $User     = new AdminUser();
        $userData = $User->find($param['id']);
        $result   = $userData->allowField([
            'nickname',
            'password',
            'mobile',
            'avatar_url',
        ])->save($param);
    }

}
