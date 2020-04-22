<?php
// 千行代码，Bug何处藏。 纵使上线又怎样，朝令改，夕断肠
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\Setting as logicSetting;
use app\model\Banner;
use think\facade\View;

class Setting extends AdminBaseController
{
    //基础配置
    public function website()
    {
        $param   = $this->request->param();
        $setting = new logicSetting();
        $tpl     = isset($param['tplType']) && !empty($param['tplType']) ? $param['tplType'] : 'baseConfig';
        View::assign('settinglist', $setting->getSettingList());
        View::assign('detail', $setting->getSettingCategoryList($tpl));
        View::assign('tpl', $tpl);
        return View::fetch($tpl, ['tplType' => $tpl]);
    }

    public function addPost()
    {
        $param   = $this->request->param();
        $setting = new logicSetting();
        $setting->saveSettingPost($param);
        $tpl = isset($param['type']) && !empty($param['type']) ? $param['type'] : 'baseConfig';
        return redirect((string) url('/admin/setting/website', ['tplType' => $tpl]));
    }


}
