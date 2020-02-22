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

    /**
     * [banner 轮播图及友情链接管理]
     * @return [type] [description]
     */
    public function banner()
    {
        $setting = new logicSetting();
        View::assign('bannerlist', $setting->getBannerList());
        return View::fetch('');
    }

    public function addBannerPost()
    {
        $param  = $this->request->param();
        $banner = new Banner();
        $data   = [
            'type' => $param['imageType'],
            'title' => $param['title'],
            'description' => $param['description'],
            'image_url' => $param['image_url'],
            'link_url' => $param['link_url'],
            'remark' => $param['remark'],
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];
        $banner->save($data);
    }

    //
    public function add()
    {
        return View::fetch('');
    }

    public function edit()
    {

        $param  = $this->request->param();
        $banner = new Banner();
        View::assign('editData', $banner->getBannerInfo($param['id']));

        return View::fetch('');
    }

    public function editBannerPost()
    {

        $param                = $this->request->param();
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;
        $bannerModel          = new Banner();

        $banner = $bannerModel->find($param['id']);
        $result = $banner->allowField([
            'title',
            'description',
            'link_url',
            'image_url',
            'remark',
            'type',
            'show_status',
        ])->save($param);

    }

    public function delete()
    {

        $param       = $this->request->param();
        $bannerModel = new Banner();
        $result      = $bannerModel->update(['delete_status' => 1], ['id' => $param['id']]);
        if ($result)
        {
            return json(['code' => 1, 'msg' => '删除成功']);
        }
        else
        {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

}
