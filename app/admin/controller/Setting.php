<?php
// 千行代码，Bug何处藏。 纵使上线又怎样，朝令改，夕断肠
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\Setting as logicSetting;
use think\facade\View;

class Setting extends AdminBaseController
{
    //基础配置
    public function website()
    {
        $setting = new logicSetting();
        View::assign('settinglist', $setting->getSettingList());
        return View::fetch('');
    }

    public function addPost()
    {
        $param   = $this->request->param();
        $setting = new logicSetting();
        $setting->saveSettingPost($param);
        return redirect('/admin/setting/website');

    }

    public function links()
    {
        return View::fetch('');
    }

    public function delete()
    {
        $param = $this->request->param();
        $data  = ['name' => $param, 'code' => '1'];
        return json($data);
    }

    //
    public function add()
    {
        return View::fetch('');

    }

    public function nav()
    {
        return View::fetch('');
    }

    public function navPost()
    {
        return View::fetch('');
    }

}
