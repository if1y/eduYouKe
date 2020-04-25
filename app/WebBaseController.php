<?php
declare (strict_types = 1);
namespace app;

use app\BaseController;
use app\util\Nav;
use app\util\Tools;
use think\facade\DB;
use think\facade\Env;
use think\facade\Request;
use think\facade\View;

class WebBaseController extends BaseController
{

    protected $layout = 'default';

    protected $template;

    protected $webTemplateDir = 'website';

    // 初始化
    protected function initialize()
    {
        //获取当前配置的模板
        $this->getWebTheme();
        View::assign('nav', $this->getNav());
        View::assign('templateName', $this->template);
    }

    /**
     * [getWebTheme 获取当前配置的模板]
     */
    public function getWebTheme()
    {
        $res = DB::name('user')->find();
        if ($res)
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/web/' . '/default/';
        }
        else
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/web/' . '/default/';
        }
        if (Env::get('DEV.RUNTIME') == 'develop')
        {

            $this->template = 'lte';

            $path = WEB_ROOT . DIRECTORY_SEPARATOR . config('view.view_dir_name') . DIRECTORY_SEPARATOR . $this->webTemplateDir . DIRECTORY_SEPARATOR . $this->template . DIRECTORY_SEPARATOR . app('http')->getName() . '/';

        }

        //模板字符串替换
        $this->viewTplReplaceString();
        View::config(['view_path' => $path]);

    }

    //模板字符串替换
    public function viewTplReplaceString()
    {
        $viewConfig = config('view');

        $tempStr = str_replace("public", "", $viewConfig['view_dir_name']) . DIRECTORY_SEPARATOR . $this->webTemplateDir . DIRECTORY_SEPARATOR . $this->template . DIRECTORY_SEPARATOR . 'public/static';

        $viewReplaceStr = [
            '__TEMPSTATIC__' => $tempStr,
        ];

        View::config(['tpl_replace_string' => array_merge($viewConfig['tpl_replace_string'], $viewReplaceStr)]);

    }

    public function getNav()
    {

        $access = DB::name('course_category')
            ->where('show_status', 1)
            ->where('delete_status', 0)
            ->order('sort', 'asc')
            ->select()->toArray();

        //组装选中状态
        $nav = Nav::buildNav(
            Tools::listToTree($access, 'id', 'parent_id')
        );
        return $nav;

    }

    //获取重定向地址
    public function redirectUrl()
    {

        $uri = session('redirect_url');

        if ($uri)
        {
            session('redirect_url', null);
            return $uri;
        }

        return '/';
    }

    //
    public function getUserCentor()
    {
        $userId = getUserInfoData();
        $mySelf = 1;

        $request = Request::instance();
        $param = $request->param();
        if (isset($param['user_id'])) {
            //判断是否为本人
            $mySelf = $userId == $param['user_id'] ? 1 : 0;
            $userId = $param['user_id']; 
        }
        if (empty($userId)) {
            Session::set('UserInfo','null');
        }
        $userInfo = DB::name('user')->where('id',$userId)->find();
        if (empty($userInfo)) {
            header('location:/user/centor');exit();
        }
        $userInfo['myself'] = $mySelf;
        return $userInfo;
    }

}
