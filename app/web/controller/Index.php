<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;

class Index extends WebBaseController
{
    public function index()
    {
        
        $list = [1,2];
        View::assign([
			'list' => $list,
        ]);
        return View::fetch();
    }
    
    /**
     * [list 课程栏目]
     * @return [type] [description]
     */
    public function list()
    {
        return View::fetch('list');
    }

    /**
     * [detail 获取详情]
     * @return [type] [description]
     */
    public function detail()
    {
        return View::fetch('detail');
    }

    /**
     * [search 获取搜索结果]
     * @return [type] [description]
     */
    public function search()
    {
        return View::fetch('search');
    }

}
