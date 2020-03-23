<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\AdminRole;
use think\facade\View;

class Role extends AdminBaseController
{

    /**
     * [AdminRoleList 获取角色组列表]
     */
    public function index()
    {
        $role = new AdminRole();
        $list = $role->where('delete_status', 0)->paginate(12);

        View::assign('rolelist', $list);
        View::assign('page', $list->render());
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
        $role  = new AdminRole();

        $data = [
            'role_name' => $param['role_name'],
            'remark' => $param['remark'],
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];
        $role->save($data);

    }

    /**
     * [edit 编辑展示页面]
     * @return [type] [description]
     */
    public function edit()
    {
        $param = $this->request->param();
        $role  = new AdminRole();
        View::assign('editData', $role->getAdminRoleInfo($param['id']));
        return View::fetch();
    }

    /**
     * [editPost 编辑提交]
     * @return [type] [description]
     */
    public function editPost()
    {
        $param = $this->request->param();

        $role                 = new AdminRole();
        $roleData             = $role->find($param['id']);
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

        $result = $roleData->allowField([
            'role_name',
            'remark',
            'show_status',
        ])->save($param);

    }

    /**
     * [delete 删除操作]
     * @return [type] [description]
     */
    public function delete()
    {
        $param  = $this->request->param();
        $role   = new AdminRole();
        $result = $role->update(['delete_status' => 1], ['id' => $param['id']]);
        if ($result)
        {
            return json(['code' => 1, 'msg' => '删除成功']);
        }
        else
        {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

    /**
     * [tree 权限树形结构图]
     * @return [type] [description]
     */
    public function tree()
    {
        $id = $this->request->param('id', 0, 'intval');
        View::assign('id', $id);
        return View::fetch();
    }

    /**
     * [tree 权限树形结构图]
     * @return [type] [description]
     */
    public function testtree()
    {
        $id = $this->request->param('id', 0, 'intval');
        View::assign('id', $id);
        return View::fetch();
    }

    /**
     * [roleAuthPost 修改用户组权限]
     * @return [type] [description]
     */
    public function roleUserAuth()
    {
        $param  = $this->request->param();
        $roleId = $param['role_id'];
        $role   = new AdminRole();
        return json([
            'code' => 1,
            'msg' => '获取成功',
            'data' => $role->getUserAuthMenu($param['role_id']),
        ]);
    }

    public function roleUserAuthPost()
    {
        $param = $this->request->param();

        $result = 0;
        if (isset($param['authStr']) && !empty($param['authStr']))
        {

            $role     = new AdminRole();
            $roleData = $role->find($param['id']);
            $result   = $roleData->allowField([
                'role_auth',
            ])->save(['role_auth' => implode(',', $param['authStr'])]);

        }
        if ($result)
        {

            return json([
                'code' => 1,
                'msg' => '成功',
            ]);
        }
        else
        {
            return json([
                'code' => 0,
                'msg' => 'error',
            ]);
        }

    }

}
