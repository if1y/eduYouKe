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
    public function index()
    {
        $courseVideo = new CourseVideoLogic();
        return view('', [
                'coursevideolist' => $courseVideo->where('delete_status', 0)->select(),
            ]);
    }

    //视频添加
    public function add($value='')
    {


        $param   = $this->request->param();
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

        $course = new Course();
        $chapter = new Chapter();
        $courseVideo = new CourseVideoLogic();


        if ($this->request->isPost())
        {

            if ($courseVideo->save($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->error('操作失败');
            }

        }
        else
        {

            $course = new Course();
            return view('', [
                'courselist' => $course->field('id,title')->where('delete_status', 0)->select(),
                'chapterlist' => $chapter->field('id,title')->where('delete_status', 0)->select(),
            ]);

        }

    }

    //视频编辑
   	public function edit()
   	{
        $param    = $this->request->param();

        $course = new Course();
        $chapter = new Chapter();
        $courseVideo = new CourseVideoLogic();


        if ($this->request->isPost())
        {

            if ($courseVideo->where('id',$param['id'])->save($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->error('操作失败');
            }

        }
        else
        {   


            $videoInfo = $courseVideo->getCourseVideoInfo($param['id']);
            $videoParent = $courseVideo->getCourseOrChapter($param['id']);

            return view('', [
                'editData' => $videoInfo,
                'courselist' => $courseVideo->selectCourseList($videoParent),
                'chapterlist' => $courseVideo->selectChapterList($videoParent),
            ]);

        }
        

   	}

   	//视频删除
	public function del()
	{
        $param   = $this->request->param();
        $courseVideo = new CourseVideoLogic();
        
        $result  = $courseVideo->update(['delete_status' => 1], ['id' => $param['id']]);
        if ($result)
        {
            return json(['code' => 1, 'msg' => '删除成功']);
        }
        else
        {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
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