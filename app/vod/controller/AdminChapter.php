<?php
namespace app\vod\controller;

use app\AdminBaseController;
use app\logic\Chapter as ChapterLogic;
use app\logic\Course;
use think\facade\View;
use app\util\Tools;
use app\vod\validate\AdminChapter as AdminChapterValidate;


class AdminChapter extends AdminBaseController
{
    protected $middleware = ['adminAuth','Access'];
    
    //首页
    public function index()
    {

        $param = $this->request->param();

        $where = Tools::buildSearchWhere($param,[
            'title','description']);
        

        $chapter = new ChapterLogic();
        $list   = $chapter->getChapterList($where);
        
        return view('', [
            'chapterlist' => $list,
            'page' => $list->render(),
        ]);

    }

    //添加
    public function add()
    {

        $param   = $this->request->param();
        $chapter = new ChapterLogic();

        if ($this->request->isPost())
        {

            //验证数据
            $validate = new AdminChapterValidate();
            if (!$validate->check($param))
            {
                $this->error($validate->getError());
            }

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
                'courselist' => $course->baseQuery([], 'id,title'),
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

            //验证数据
            $validate = new AdminChapterValidate();
            if (!$validate->check($param))
            {
                $this->error($validate->getError());
            }
            
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
        $id = $this->request->param('id', 0, 'intval');

        $chapter = new ChapterLogic();
        $result  = $chapter->update(['delete_status' => 1], ['id' => $id]);
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
