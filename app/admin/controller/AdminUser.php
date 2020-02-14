<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\AdminUser as User;
use app\util\Tools;
use think\facade\View;
use think\Validate;


class AdminUser extends AdminBaseController
{
    /**
     * [AdminUserList 管理员列表]
     */
    public function AdminUserList()
    {
        $User = new User();
        View::assign('userlist', $User->where('delete_status', 0)->select());
        return View::fetch();
    }

    /**
     * [add 添加管理员]
     */
    public function add()
    {
        return View::fetch();
    }

    public function addPost()
    {

        $param = $this->request->param();
        $User  = new User();
        $data  = [
            'nickname' => $param['nickname'],
            'password' => Tools::userMd5($param['password']),
            'mobile' => $param['mobile'],
            'role_id' => $param['role_id'],
            'avatar_url' => !empty($param['avatar_url']) ? $param['avatar_url'] : '',
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];
        $User->save($data);

    }

    /**
     * [edit 编辑展示页面]
     * @return [type] [description]
     */
    public function edit()
    {
        $param = $this->request->param();
        $User  = new User();
        View::assign('editData', $User->getAdminUserInfo($param['id']));
        return View::fetch();
    }

    /**
     * [editPost 编辑提交]
     * @return [type] [description]
     */
    public function editPost()
    {
        $param = $this->request->param();
        $param['password'] = Tools::userMd5($param['password']);
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;
            
        $User  = new User();
        $userData = $User->find($param['id']);
        $userData->allowField([
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


    public function upload()
    {
        return View::fetch();
    }


    public function uploadPost()
    {
        $file = request()->file('file');
        $savename = \think\facade\Filesystem::putFile( 'topic', $file);
        print_r($savename);exit();
    }

}