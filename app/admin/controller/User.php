<?php
namespace app\admin\controller;

use app\AdminBaseController;
use think\facade\Session;
use think\facade\View;
use app\util\Tools;
use app\logic\User as UserLogic;


class User extends AdminBaseController
{
    public function index()
    {
        $user  = new UserLogic();

        $list = $user->getUserList();

        return view('',[
            'userlist'=>$list,
            'page'=>$list->render(),
        ]);
    }


        /**
     * [add 添加用户]
     */
    public function add()
    {
        $param = $this->request->param();

        //
        if ($this->request->isPost())
        {
            $User  = new UserLogic();

            $param['password']    = Tools::userMd5($param['password']);

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
        $User  = new UserLogic();
        //
        if ($this->request->isPost())
        {

            $param['password']    = !empty($param['password']) ? Tools::userMd5($param['password']) : 0;

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

        }
        else
        {

            View::assign('editData', $User->getUserInfo($param['id']));
            return View::fetch();
        }
    }


    /**
     * [delete 删除操作]
     * @return [type] [description]
     */
    public function del()
    {
        $param  = $this->request->param();
        
        $User  = new UserLogic();

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


}
