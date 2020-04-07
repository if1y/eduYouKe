<?php
declare (strict_types = 1);
namespace app;

use app\BaseController;
use think\facade\DB;
use think\facade\View;
use think\facade\Env;


class WebBaseController extends BaseController
{

    protected $layout = 'default';

    protected $template;

    // 初始化
    protected function initialize()
    {
        //获取当前配置的模板
        $this->getWebTheme();
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
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/' . app('http')->getName() . '/default/';
        }
        else
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/' . app('http')->getName() . '/default/';
        }
        if (Env::get('DEV.RUNTIME') == 'develop')
        {

            $this->template = 'lte';
            $path           = WEB_ROOT . '/' . config('view.view_dir_name') . '/' . app('http')->getName() . '/lte/';
        }
        
        View::config(['view_path' => $path]);

    }

}
