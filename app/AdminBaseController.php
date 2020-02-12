<?php
declare (strict_types = 1);
namespace app;

use app\BaseController;
use app\util\Menu;
use app\util\Tools;
use think\facade\DB;
use think\facade\Env;
use think\facade\View;

class AdminBaseController extends BaseController
{

    //模板继承
    protected $layout = 'default';

    // 初始化
    protected function initialize()
    {
        //获取当前配置的模板
        $this->getWebTheme();
        View::assign('adminMenus', $this->getMenus());
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
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/' . app('http')->getName() . '/' . $this->layout . '/';
        }
        else
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/' . app('http')->getName() . '/' . $this->layout . '/';
        }
        if (Env::get('DEV.RUNTIME') == 'develop')
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/' . app('http')->getName() . '/adminlte/';

        }
        View::config(['view_path' => $path]);

    }

    final public function getMenus()
    {

        $access = DB::name('admin_menu')
            ->where('show_status', 1)
            ->where('delete_status',0)
            ->order('sort', 'desc')
            ->select()->toArray();

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
