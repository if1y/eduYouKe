<?php
namespace app\admin\controller;

use app\AdminBaseController;
use think\facade\View;
use app\logic\Dict as DictLogic;

class Dict extends AdminBaseController
{
	public function index()
	{
		$dict = new DictLogic();

		$list = $dict->getDictList();

		return view('', [
            'dictlist' => $list,
            'page' => $list->render(),
        ]);
	}



	public function add()
    {

        $param  = $this->request->param();
        $dict = new DictLogic();

        if ($this->request->isPost())
        {

            $param['show_status'] = isset($param['show_status']) ? $param['show_status'] : 0;

            if ($dict->saveDict($param))
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
            $dict = new DictLogic();
            return view('', [
            	'dictlist' => $dict->getDictList(['type'=>1]),
            ]);
        }

    }

    public function edit()
    {

        $param  = $this->request->param();
        $dict = new DictLogic();

        if ($this->request->isPost())
        {

            $param['show_status'] = isset($param['show_status']) ? 1 : 0;

            if ($dict->where('id', $param['id'])->save($param))
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
            return view('', [
            	'editData' => $dict->getDictInfo($param['id']),
            	'dictlist' => $dict->getDictList(['type'=>1]),
            ]);
        }

    }

    /**
     * [delete 删除操作]
     * @return [type] [description]
     */
    public function del()
    {
        $id = $this->request->param('id', 0, 'intval');

        $dict = new DictLogic();

        $result = $dict->update(['delete_status' => 1], ['id' => $id]);
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