<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\Nav as NavLogic;
use app\logic\CourseCategory;
use think\facade\View;

class Nav extends AdminBaseController
{

	public function index()
	{
		$nav = new NavLogic();

        return view('', [
            'navlist' => $nav->getNavlist(),
        ]);

	}

	//添加
    public function add()
    {

        $param    = $this->request->param();
		$nav = new NavLogic();
        $category = new CourseCategory();

        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

        if ($this->request->isPost())
        {
            if ($nav->save($param))
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
                'navlist' => $nav->getNavlist(),
                'category' => $category->getCategoryList(),
            ]);

        }

    }

    //编辑
    public function edit()
    {

        $param    = $this->request->param();

		$nav = new NavLogic();
        $category = new CourseCategory();

        $param['show_status'] = !empty($param['show_status']) ? 1 : 0;

        if ($this->request->isPost())
        {
            if ($nav->where('id', $param['id'])->save($param))
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
        	// print_r($nav->getNavInfo($param['id'])->toArray());exit;
            return view('', [
                'editData' => $nav->getNavInfo($param['id']),
                'navlist' => $nav->getNavlist(),
                'category' => $category->getCategoryList(),
            ]);

        }

    }

    //删除
    public function del()
    {
        $param    = $this->request->param();
		$nav = new NavLogic();
        $result   = $nav->update(['delete_status' => 1], ['id' => $param['id']]);
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