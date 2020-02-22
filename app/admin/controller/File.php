<?php
namespace app\admin\controller;
use app\AdminBaseController;
use think\facade\View;
use app\logic\Config;


class File extends AdminBaseController
{
	//登录
    public function filelist()
    {
        $setting = new Setting();
        View::assign('settinglist', $setting->where('category','testConfig')->select());
        // $setting = new Setting();
        // $result = $setting->buildConfigHtml();
        // print_r($result);exit();
        return View::fetch('');
    }


    public function website()
    {
        $config = new Config();
        // $result = $config->where('category','testConfig')->select();
        // print_r($result);exit();
        View::assign('settinglist', $config->getSettingList());
        // $setting = new Setting();
        // $result = $setting->buildConfigHtml();
        // print_r($result);exit();
        return View::fetch('');
    }




}
