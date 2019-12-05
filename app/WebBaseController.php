<?php
declare (strict_types = 1);
namespace app;
use think\facade\View;
use think\facade\DB;
use app\BaseController;


class WebBaseController extends BaseController{

    // 初始化
    protected function initialize()
    {
        //获取当前配置的模板
        $this->getWebTheme();
    }

    /**
     * [getWebTheme 获取当前配置的模板]
     */
    public function getWebTheme()
    {
        $res = DB::name('user')->find();
        if($res){
            $path = WEB_ROOT.'/'.config('view.view_dir_name').'/'.app('http')->getName().'/default/';
        }else{
            $path = WEB_ROOT.'/'.config('view.view_dir_name').'/'.app('http')->getName().'/default/';
        }
        View::config(['view_path' =>$path]);

    }

}
