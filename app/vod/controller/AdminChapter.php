<?php
namespace app\vod\controller;

use app\AdminBaseController;
use app\logic\Chapter as ChapterLogic;
use app\logic\Course;
use think\facade\View;

class AdminChapter extends AdminBaseController
{
    //首页
    public function index()
    {
        $chapter = new ChapterLogic();
        return view('', [
                'chapterlist' => $chapter->where('delete_status', 0)->select(),
            ]);
    }

    //添加
    public function add()
    {

        $param   = $this->request->param();
        $chapter = new ChapterLogic();

        if ($this->request->isPost())
        {
            if ($chapter->save($param))
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
                'courselist' => $course->getCourseList([], 'id,title'),
            ]);

        }

    }

    //编辑操作
    public function edit()
    {

        $param   = $this->request->param();
        $chapter = new ChapterLogic();

        if ($this->request->isPost())
        {
            $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

            if ($chapter->where('id', $param['id'])->save($param))
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

            return view('', [
                'editData' => $chapter->getChapterInfo($param['id']),
            ]);
        }
    }

    /**
     * [delete 删除课程操作]
     * @return [type] [description]
     */
    public function del()
    {
        $param   = $this->request->param();
        $chapter = new ChapterLogic();
        $result  = $chapter->update(['delete_status' => 1], ['id' => $param['id']]);
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
