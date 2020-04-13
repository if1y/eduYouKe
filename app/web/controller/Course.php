<?php
namespace app\web\controller;

use app\logic\Chapter;
use app\logic\Course as CourseLogic;
use app\logic\CourseVideo;
use app\logic\Comment;
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
        $param = $this->request->param();

        $cours   = new CourseLogic();
        $chapter = new Chapter();

        //获取详情
        $coursInfo = $cours->getCourseInfo($param['id']);
        //获取面包屑
        $breadcrumb = $cours->getBreadcrumb($param['id']);

        //获取最近更新
        $recommendCourse = $chapter->getRecommendRoundCourse($coursInfo['category_id']);

        //更新观看日志&&观看次数
        $cours->updateViewAndLog($param);
        
        return view('', [
            'coursinfo' => $coursInfo,
            'breadcrumb' => $breadcrumb,
            'recommend' => $recommendCourse,
        ]);

    }

    /**
     * [chapter 课程章节]
     * @return [type] [description]
     */
    public function chapter()
    {

        $param = $this->request->param();

        $cours   = new CourseLogic();
        $chapter = new Chapter();

        //获取详情
        $coursInfo = $cours->getCourseInfo($param['id']);
        //获取面包屑
        $breadcrumb = $cours->getBreadcrumb($param['id']);

        //获取推荐课程
        $recommendCourse = $chapter->getRecommendRoundCourse($coursInfo['category_id']);

        //获取章节
        $chapterList = $chapter->getChapter($param['id']);

        return view('', [
            'coursinfo' => $coursInfo,
            'breadcrumb' => $breadcrumb,
            'chapterlist' => $chapterList,
            'recommend' => $recommendCourse,
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

        $cours   = new CourseLogic();
        $chapter = new Chapter();
        $comment = new Comment();


        //获取详情
        $coursInfo = $cours->getCourseInfo($param['id']);
        //获取面包屑
        $breadcrumb = $cours->getBreadcrumb($param['id']);
        //获取最近更新
        $recommendCourse = $chapter->getRecommendRoundCourse($coursInfo['category_id']);
        //获取评论
        $commentList = $comment->getCommentList('course',$param['id']);

        return view('', [
            'coursinfo' => $coursInfo,
            'breadcrumb' => $breadcrumb,
            'recommend' => $recommendCourse,
            'commentlist' => $commentList,
            'page' => $commentList->render(),
        ]);
    }

    /**
     * [detail 获取课程详情]
     * @return [type] [description]
     */
    public function detail()
    {

        $param = $this->request->param();

        $video   = new CourseVideo();
        $cours   = new CourseLogic();
        $chapter = new Chapter();

        //获取详情
        $coursInfo = $cours->getCourseInfo($param['course_id']);
        //获取面包屑
        $breadcrumb = $cours->getBreadcrumb($param['course_id']);
        //获取最近更新
        $recommendCourse = $chapter->getRecommendRoundCourse($coursInfo['category_id']);
        //获取章节
        $chapterList = $chapter->getChapter($param['course_id']);

        $videoInfo = $video->getVideoInfo($param['id']);

        return view('', [
            'coursinfo' => $coursInfo,
            'videoinfo' => $videoInfo,
            'breadcrumb' => $breadcrumb,
            'chapterlist' => $chapterList,
            'recommend' => $recommendCourse,
        ]);
    }

}
