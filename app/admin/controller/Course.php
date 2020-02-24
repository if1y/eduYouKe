<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\CourseCategory;
use think\facade\View;

class Course extends AdminBaseController
{
    public function courselist()
    {
        return View::fetch();
    }

    public function add()
    {
        return View::fetch();
    }

    public function category()
    {
        $category = new CourseCategory();
        View::assign('categorylist', $category->getCategoryList());
        return View::fetch();
    }

    public function addCategory()
    {

        $category = new CourseCategory();
        View::assign('category', $category->getCategoryList());
        return View::fetch();
    }

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

    public function editCategory()
    {
        $param    = $this->request->param();
        $category = new CourseCategory();
        View::assign('editData', $category->getCourseCategoryInfo($param['id']));
        View::assign('categorylist', $category->getCategoryList());
        return View::fetch();
    }

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

    public function delCategory($value = '')
    {

    	$param = $this->request->param();
        $category = new CourseCategory();
        $result = $category->update(['delete_status'=> 1],['id'=>$param['id']]);
        if ($result) {
            return json(['code'=>1,'msg'=>'删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'删除失败']);
        }
    }

    public function coursevideo()
    {
        return View::fetch();
    }

}
