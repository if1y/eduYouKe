<?php
declare (strict_types = 1);
namespace app;

use app\BaseController;
use app\util\Menu;
use app\util\Tools;
use think\exception\HttpResponseException;
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

    //
    // 以下为新增，为了使用旧版的 success error redirect 跳转  start
    //

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function success($msg = '', string $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"]))
        {
            $url = $_SERVER["HTTP_REFERER"];
        }
        elseif ($url)
        {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url);
        }

        $result = [
            'code' => 1,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ($type == 'html')
        {
            $response = view($this->app->config->get('app.dispatch_success_tmpl'), $result);
        }
        elseif ($type == 'json')
        {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', string $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url))
        {
            $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
        }
        elseif ($url)
        {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app->route->buildUrl($url);
        }

        $result = [
            'code' => 0,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ($type == 'html')
        {
            $response = view($this->app->config->get('app.dispatch_error_tmpl'), $result);
        }
        elseif ($type == 'json')
        {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * URL重定向  自带重定向无效
     * @access protected
     * @param  string         $url 跳转的URL表达式
     * @param  array|integer  $params 其它URL参数
     * @param  integer        $code http code
     * @param  array          $with 隐式传参
     * @return void
     */
    protected function redirect($url, $params = [], $code = 302, $with = [])
    {
        $response = Response::create($url, 'redirect');

        if (is_integer($params))
        {
            $code   = $params;
            $params = [];
        }

        $response->code($code)->params($params)->with($with);

        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return $this->request->isJson() || $this->request->isAjax() ? 'json' : 'html';
    }

}
