<?php
namespace app\admin\controller;

use app\AdminBaseController;
use think\facade\View;
use app\logic\Chapter;
use app\logic\Course;
use app\logic\CourseVideo as CourseVideoLogic;


class CourseVideo extends AdminBaseController
{
    //视频列表
    public function coursevideolist()
    {
        $courseVideo = new CourseVideoLogic();
        View::assign('coursevideolist', $courseVideo->where('delete_status', 0)->select());
        return View::fetch('');
    }

    //视频添加
    public function add($value='')
    {
    	$course = new Course();
    	$chapter = new Chapter();
		View::assign('courselist', $course->field('id,title')->where('delete_status', 0)->select());
		View::assign('chapterlist', $chapter->field('id,title')->where('delete_status', 0)->select());
        return View::fetch('');

    }

    //视频编辑
   	public function edit()
   	{
        $param    = $this->request->param();

        $course = new Course();
        $chapter = new Chapter();
        $courseVideo = new CourseVideoLogic();
        $videoInfo = $courseVideo->getCourseVideoInfo($param['id']);
        $videoParent = $courseVideo->getCourseOrChapter($param['id']);

        View::assign('editData', $videoInfo);
        View::assign('courselist', $courseVideo->selectCourseList($videoParent));
        View::assign('chapterlist', $courseVideo->selectChapterList($videoParent));

        return View::fetch('');
   	}

   	//视频添加提交
   	public function addPost()
   	{

        $param    = $this->request->param();
        $courseVideo = new CourseVideoLogic();

        $data     = [
            'course_id' => $param['course_id'],
            'chapter_id' => $param['chapter_id'],
            'title' => $param['title'],
            'description' => $param['description'],
            'seoTitle' => $param['seoTitle'],
            'seoKeywords' => $param['seoKeywords'],
            'seoDescription' => $param['seoDescription'],
            'image_url' => $param['image_url'],
            'vide_url' => $param['vide_url'],
            'remark' => $param['remark'],
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];
        $courseVideo->save($data);

   	}

   	//视频编辑提交
   	public function editPost()
   	{
        $param = $this->request->param();
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

        $courseVideo = new CourseVideoLogic();
        $courseVideoData = $courseVideo->find($param['id']);

        $result = $courseVideoData->allowField([
            'chapter_id',
            'description',
            'image_url',
            'vide_url',
            'seoTitle',
            'seoKeywords',
            'seoDescription',
            'remark',
            'show_status',
        ])->save($param);


   	}

   	//视频删除
	public function delete()
	{
		# code...
	}


    public function getChapterList()
    {
        $param    = $this->request->param();
        $chapter = new Chapter();
        $data = $chapter
        ->field('id,course_id,title')
        ->where(['delete_status'=>0,'course_id'=>$param['course_id']])
        ->select()->toArray();
        return json(['code'=>1,'data'=>$data]);
    }	

}