<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;
use app\logic\Course as CourseLogic;

class Course extends WebBaseController
{
    
    /**
     * [index 课程首页]
     * @return [type] [description]
     */
    public function index()
    {
        $param = $this->request->param();

        $cours = new CourseLogic();
        //获取详情
        $coursInfo = $cours->getCourseInfo($param['id']);
        //获取面包屑
        $breadcrumb = $cours->getBreadcrumb($param['id']);


        //获取最近更新

        return view('', [
            'coursinfo' => $coursInfo,
            'breadcrumb' => $breadcrumb,
        ]);

    }

    /**
     * [chapter 课程章节]
     * @return [type] [description]
     */
    public function chapter()
    {

        $param = $this->request->param();

        $cours = new CourseLogic();
        //获取详情
        $coursInfo = $cours->getCourseInfo($param['id']);
        //获取面包屑
        $breadcrumb = $cours->getBreadcrumb($param['id']);

        //获取最近更新

        return view('', [
            'coursinfo' => $coursInfo,
            'breadcrumb' => $breadcrumb,
        ]);
    }


    /**
     * [articleList 课程关联文章]
     * @return [type] [description]
     */
    public function articleList()
    {
        return View::fetch('articleList');
    }
    

    /**
     * [commentList 课程评论]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function comment()
    {
        $param = $this->request->param();

        $cours = new CourseLogic();
        //获取详情
        $coursInfo = $cours->getCourseInfo($param['id']);
        //获取面包屑
        $breadcrumb = $cours->getBreadcrumb($param['id']);

        //获取最近更新

        return view('', [
            'coursinfo' => $coursInfo,
            'breadcrumb' => $breadcrumb,
        ]);
    }

    /**
     * [detail 获取课程详情]
     * @return [type] [description]
     */
    public function detail()
    {
        return View::fetch('detail');
    }
    
}
