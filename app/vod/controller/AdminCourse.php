<?php
namespace app\vod\controller;

use app\AdminBaseController;
use app\logic\Course as CourseLogic;
use app\logic\CourseCategory;
use think\facade\View;
use app\util\Tools;
use app\vod\validate\AdminCourse as AdminCourseValidate;

class AdminCourse extends AdminBaseController
{

    /**
     * [courselist 课程列表/章节列表]
     * @return [type] [description]
     */
    public function index()
    {
        $param = $this->request->param();

        $cours = new CourseLogic();

        $where = Tools::buildSearchWhere($param,[
            'title','description']);
        
        $list   = $cours->getCourseList($where);

        return view('', [
            'courslist' => $list,
            'page' => $list->render(),
        ]);

    }

    //添加课程
    public function add()
    {

        $param = $this->request->param();
        $cours = new CourseLogic();

        if ($this->request->isPost())
        {

            //验证数据
            $validate = new AdminCourseValidate();
            if (!$validate->check($param))
            {
                $this->error($validate->getError());
            }

            $param['show_status'] = isset($param['show_status']) ? $param['show_status'] : 0;

            if ($cours->save($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->success('操做失败');
            }

        }
        else
        {

            $category = new CourseCategory();
            View::assign('categorylist', $category->getCategoryList());
            return View::fetch();
        }
    }

    //编辑课程
    public function edit()
    {

        $param    = $this->request->param();
        $cours    = new CourseLogic();
        $category = new CourseCategory();
        if ($this->request->isPost())
        {

            unset($param['file']);
            //验证数据
            $validate = new AdminCourseValidate();
            if (!$validate->check($param))
            {
                $this->error($validate->getError());
            }

            $param['show_status'] = isset($param['show_status']) ? $param['show_status'] : 0;

            if ($cours->where('id', $param['id'])->save($param))
            {
                $this->success('操作成功');
            }
            else
            {
                $this->success('操做失败');
            }

        }
        else
        {

            View::assign('categorylist', $category->getCategoryList());
            View::assign('editData', $cours->getCourseInfo($param['id']));
            return View::fetch();
        }
    }

    /**
     * [delete 删除课程操作]
     * @return [type] [description]
     */
    public function del()
    {
        $id = $this->request->param('id', 0, 'intval');

        $cours  = new CourseLogic();
        $result = $cours->update(['delete_status' => 1], ['id' => $id]);
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
