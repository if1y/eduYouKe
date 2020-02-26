<?php
namespace app\admin\controller;

use app\AdminBaseController;
use think\facade\View;
use app\logic\Chapter;
use app\logic\Course;


class CourseVideo extends AdminBaseController
{
    //视频列表
    public function coursevideolist()
    {
        return View::fetch('');
    }

    //视频添加
    public function add($value='')
    {
    	$course = new Course();
    	$chapter = new Chapter();
		View::assign('courslist', $course->field('id,title')->where('delete_status', 0)->select());
		View::assign('chapterlist', $chapter->field('id,title')->where('delete_status', 0)->select());
        return View::fetch('');

    }

    //视频编辑
   	public function edit()
   	{
        return View::fetch('');
   	}

   	//视频添加提交
   	public function addPost()
   	{
   		# code...
   	}

   	//视频编辑提交
   	public function editPost()
   	{
   		# code...
   	}

   	//视频删除
	public function delete()
	{
		# code...
	}   	

}