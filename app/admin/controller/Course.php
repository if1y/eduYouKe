<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\Chapter;
use app\logic\Course as CourseLogic;
use app\logic\CourseCategory;
use think\facade\View;

class Course extends AdminBaseController
{

    //课程分类列表
    public function category()
    {
        $category = new CourseCategory();
        View::assign('categorylist', $category->getCategoryList());
        return View::fetch();
    }

    //添加课程分类
    public function addCategory()
    {

        $category = new CourseCategory();
        View::assign('category', $category->getCategoryList());
        return View::fetch();
    }

    //添加课程分类提交
    public function addPostCategory()
    {
        $param    = $this->request->param();
        $category = new CourseCategory();
        $data     = [
            'parent_id' => $param['parent_id'],
            'title' => $param['title'],
            'seoTitle' => $param['seoTitle'],
            'seoKeywords' => $param['seoKeywords'],
            'seoDescription' => $param['seoDescription'],
            'remark' => $param['remark'],
            'sort' => $param['sort'],
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];
        $category->save($data);
    }

    //编辑课程分类
    public function editCategory()
    {
        $param    = $this->request->param();
        $category = new CourseCategory();
        View::assign('editData', $category->getCourseCategoryInfo($param['id']));
        View::assign('categorylist', $category->getCategoryList());
        return View::fetch();
    }

    //编辑课程分类提交
    public function editPostCategory($value = '')
    {

        $param = $this->request->param();

        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

        $category     = new CourseCategory();
        $categoryData = $category->find($param['id']);

        $result = $categoryData->allowField([
            'parent_id',
            'title',
            'seoTitle',
            'seoKeywords',
            'seoDescription',
            'remark',
            'sort',
            'show_status',
        ])->save($param);

    }

    //删除课程分类
    public function delCategory($value = '')
    {

        $param    = $this->request->param();
        $category = new CourseCategory();
        $result   = $category->update(['delete_status' => 1], ['id' => $param['id']]);
        if ($result)
        {
            return json(['code' => 1, 'msg' => '删除成功']);
        }
        else
        {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

    /**
     * [courselist 课程列表/章节列表]
     * @return [type] [description]
     */
    public function courselist()
    {
        $param = $this->request->param();
        if (isset($param['tplType']))
        {
            $chapter = new Chapter();
            View::assign('id', $param['id']);
            View::assign('chapterlist', $chapter->where('delete_status', 0)->select());
            return View::fetch($param['tplType']);
        }
        else
        {
            $cours = new CourseLogic();
            View::assign('courslist', $cours->where('delete_status', 0)->select());
            return View::fetch();
        }
    }

    //添加课程
    public function add()
    {

        $category = new CourseCategory();
        View::assign('categorylist', $category->getCategoryList());
        return View::fetch();
    }

    //编辑课程
    public function edit()
    {

        $param    = $this->request->param();
        $cours    = new CourseLogic();
        $category = new CourseCategory();
        View::assign('categorylist', $category->getCategoryList());
        View::assign('editData', $cours->getCourseInfo($param['id']));
        return View::fetch();
    }

    //提交课程
    public function addPost()
    {
        $param = $this->request->param();
        $cours = new CourseLogic();
        $data  = [
            'category_id' => $param['category_id'],
            'title' => $param['title'],
            'description' => $param['description'],
            'cource_image_url' => $param['cource_image_url'],
            'sell_status' => $param['sell_status'],
            'content' => $param['content'],
            'sell_price' => $param['sell_price'],
            'cource_tag' => $param['cource_tag'],
            'remark' => $param['remark'],
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];
        $cours->save($data);

    }

    //编辑课程提交
    public function editPost()
    {
        $param = $this->request->param();

        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;
        $cours                = new CourseLogic();
        $coursData            = $cours->find($param['id']);

        $result = $coursData->allowField([
            'category_id',
            'title',
            'description',
            'cource_image_url',
            'sell_status',
            'content',
            'sell_price',
            'cource_tag',
            'remark',
            'show_status',
        ])->save($param);
    }

    /**
     * [delete 删除课程操作]
     * @return [type] [description]
     */
    public function delete()
    {
        $param  = $this->request->param();
        $cours  = new CourseLogic();
        $result = $cours->update(['delete_status' => 1], ['id' => $param['id']]);
        if ($result)
        {
            return json(['code' => 1, 'msg' => '删除成功']);
        }
        else
        {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

    //添加章节
    public function addChapter()
    {
        return View::fetch();
    }

    //添加章节提交
    public function addPostChapter()
    {

        $param   = $this->request->param();
        $chapter = new Chapter();

        $data = [
            'course_id' => $param['course_id'],
            'title' => $param['title'],
            'description' => $param['description'],
            'remark' => $param['remark'],
            'show_status' => !empty($param['show_status']) ? 1 : 0,
        ];

        $chapter->save($data);

    }

    //编辑章节
    public function editChapter()
    {
        $param   = $this->request->param();
        $chapter = new Chapter();
        View::assign('editData', $chapter->getChapterInfo($param['id']));
        return View::fetch();
    }

    //编辑章节提交
    public function editPostChapter()
    {
        $param                = $this->request->param();
        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

        $chapter     = new Chapter();
        $chapterData = $chapter->find($param['id']);

        $result = $chapterData->allowField([
            'title',
            'description',
            'remark',
            'show_status',
        ])->save($param);

    }

    //删除章节操作
    public function delChapter()
    {

        $param   = $this->request->param();
        $chapter = new Chapter();

        $result = $chapter->update(['delete_status' => 1], ['id' => $param['id']]);
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
