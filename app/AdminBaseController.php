<?php
declare (strict_types = 1);
namespace app;

use app\BaseController;
use app\util\Menu;
use app\util\Tools;
use think\facade\Db;
use think\facade\Env;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class AdminBaseController extends BaseController
{
    //模板继承
    protected $layout = 'default';

    protected $template;

    protected $rbacConditionUserId;

    // 初始化
    protected function initialize()
    {
        
        //获取当前配置的模板
        $this->getWebTheme();
        if (empty(Session::get('adminUserInfo')))
        {
            header("Location:" . url("admin/login/login"));
            exit();
        }
        else
        {
            View::assign('templateName', $this->template);
            View::assign('adminMenus', $this->getMenus());
            View::assign('contentHeader', $this->getContentHeader());
        }
        //模板继承
        if ($this->layout)
        {
            View::layout('layout/' . $this->layout);
        }
    }

    /**
     * [getWebTheme 获取当前配置的模板]
     */
    public function getWebTheme()
    {
        $res = DB::name('user')->find();
        if ($res)
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/admin/' . app('http')->getName() . '/' . $this->layout . '/';
        }
        else
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/admin/' . app('http')->getName() . '/' . $this->layout . '/';
        }
        if (Env::get('DEV.RUNTIME') == 'develop')
        {
            $this->template = 'adminlte';
            $path           = WEB_ROOT . '/' . config('view.view_dir_name') . '/admin/'  . '/adminlte/'.app('http')->getName().'/';

        }
        // print_r(View::config('view_path'));
        View::config(['view_path' => $path]);

    }

    //contentHeader获取当前header头的内容
    public function getContentHeader()
    {
        return Menu::buildContentHeader();
    }

    final public function getMenus()
    {

        $userInfo = json_decode(Session::get('adminUserInfo'), true);
        $role_id  = $userInfo['role_id'];
        Session::set('admin_nickname', $userInfo['nickname']);
        Session::set('admin_userid', $userInfo['id']);
        // echo Session::get('admin_nickname');
        // exit;
        if ($role_id !== 1)
        {

            $role = DB::name('admin_role')->field('role_auth')->where('delete_status', 0)
                ->where('id', $role_id)->find();

            Session::set('adminAuth', $role['role_auth']);
            if (empty($role['role_auth']))
            {
                Session::set('adminUserInfo', null);
                return;
            }
            $whereIn = [
                ['id', 'in', $role['role_auth']],
            ];

        }
        else
        {

            $whereIn = [];
        }

        $access = DB::name('admin_menu')
            ->where('show_status', 1)
            ->where('delete_status', 0)
            ->where('type', 'in', '1,2')
            ->where($whereIn)
            ->order('sort', 'asc')
            ->select()->toArray();

        // print_r($access);exit();

        //组装选中状态
        $access = Menu::getActiveStatus($access);
        // print_r($access);exit();

        //判断当前权限

        // if ($type)
        // {
        //     $roleObj = new AdminRole();
        //     $adminRoleResult = $userInfo['module_id'];
        //     // $adminRoleResult = cache('adminRoleResult:' . $userInfo['id']);
        //     $adminRoleResult = explode(',', str_replace("，", ",", $adminRoleResult));

        //     foreach ($access as $key => $value)
        //     {
        //         $value['auth'] = in_array($value['id'], $adminRoleResult) ? 1 : 0;
        //         $access[$key]  = $value;
        //     }
        // }
        //

        //组装目录
        
        $menus = Menu::buildMenus(
            Tools::listToTree($access, 'id', 'parent_id')
        );
        return $menus;
    }


}
