<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;

class Course extends WebBaseController
{
    
    /**
     * [index 课程首页]
     * @return [type] [description]
     */
    public function index()
    {
        return View::fetch('index');
    }

    /**
     * [chapter 课程章节]
     * @return [type] [description]
     */
    public function chapter()
    {
        return View::fetch('chapter');
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
    public function commentList()
    {
        return View::fetch('commentList');
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
