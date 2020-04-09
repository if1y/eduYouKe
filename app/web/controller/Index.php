<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;
use app\logic\Banner;


class Index extends WebBaseController
{
    public function index()
    {
        $banner = new Banner();
        $bannerList = $banner->getBannerList(['type'=>1],'link_url,image_url');
        return view('',['bannerlist'=>$bannerList]);
    }
    
    /**
     * [list 课程栏目]
     * @return [type] [description]
     */
    public function list()
    {
        return View::fetch('list');
    }

    /**
     * [detail 获取详情]
     * @return [type] [description]
     */
    public function detail()
    {
        return View::fetch('detail');
    }

    /**
     * [search 获取搜索结果]
     * @return [type] [description]
     */
    public function search()
    {
        return View::fetch('search');
    }

}
