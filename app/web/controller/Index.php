<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;
use app\logic\Banner;
use app\logic\Course;


class Index extends WebBaseController
{
    public function index()
    {
        $banner = new Banner();
        $course = new Course();
        $bannerList = $banner->getBannerList(['type'=>1],'link_url,image_url');

        return view('',[
            'bannerlist'=>$bannerList,
            'newcourse'=>$course->getNewCourse(),  //新课程
            'recommendcourse'=>$course->getRecommendCourse(), //推荐课程
            'hotcourse'=>$course->getHotCourse(), //热门课程
            'conjecturecourse'=>$course->getConjectureCourse(),   // 猜你喜欢
        ]);
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
