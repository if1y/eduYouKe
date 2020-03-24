<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\AdminUser as User;
use app\logic\AdminRole as Role;
use app\util\Tools;
use think\facade\View;
use think\Validate;


class Administrator extends AdminBaseController
{
    /**
     * [AdminUserList 管理员列表]
     */
    public function index()
    {
        $User = new User();
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
        if ($this->request->isPost()) {

            return json(['code'=>1,'msg'=>'删除失败']);
            print_r($param);exit();
            $User  = new User();
            $data  = [
                'nickname' => $param['nickname'],
                'password' => Tools::userMd5($param['password']),
                'mobile' => $param['mobile'],
                'user_type' => $param['user_type'],
                'role_id' => $param['role_id'],
                'avatar_url' => !empty($param['avatar_url']) ? $param['avatar_url'] : '',
                'show_status' => !empty($param['show_status']) ? 1 : 0,
            ];
            return json(['code'=>1,'msg'=>'删除成功']);

            $User->save($data);

        }else{

            $role = new Role();
            View::assign('rolelist', $role->where('delete_status', 0)->select());
            return View::fetch();
        }
    }

    public function addPost()
    {

        $param = $this->request->param();
        
        $User  = new User();
        $data  = [
            'nickname' => $param['nickname'],
            'password' => Tools::userMd5($param['password']),
            'mobile' => $param['mobile'],
            'user_type' => $param['user_type'],
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
        $role = new Role();
        View::assign('rolelist', $role->where('delete_status', 0)->select());
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

        $param['password'] = !empty($param['password']) ? Tools::userMd5($param['password']):0;
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;
        if (!$param['password']) {unset($param['password']);}

        $User  = new User();
        $userData = $User->find($param['id']);
        $result = $userData->allowField([
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
    public function delete()
    {
        $param = $this->request->param();
        $User  = new User();
        $result = $User->update(['delete_status'=> 1],['id'=>$param['id']]);
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
        $savename = \think\facade\Filesystem::disk('public')->putFile( 'topic', $file);
        return json(['code'=>1,'path'=>$savename]);

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
        $User  = new User();
        View::assign('editData', $User->getAdminUserInfo($param['id']));
        return View::fetch();
    }

    //
    public function editInfoPost()
    {

        $param = $this->request->param();

        $param['password'] = !empty($param['password']) ? Tools::userMd5($param['password']):0;
        if (!$param['password']) {unset($param['password']);}

        $User  = new User();
        $userData = $User->find($param['id']);
        $result = $userData->allowField([
            'nickname',
            'password',
            'mobile',
            'avatar_url',
        ])->save($param);
    }


}
