<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\Banner as BannerLogic;
use think\facade\View;

class Banner extends AdminBaseController
{

	public function index()
	{
		$banner = new BannerLogic();
		return view('',['bannerlist'=>$banner->getBannerList()]);

	}

	public function add()
	{


		$param   = $this->request->param();
		$banner = new BannerLogic();

        if ($this->request->isPost())
        {
            $param['show_status'] = isset($param['show_status']) ? $param['show_status'] : 0;

            if ($banner->save($param))
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
        	$banner = new BannerLogic();
			return view('',['menulist'=>[]]);
        }


	}

	public function edit()
	{

		$param    = $this->request->param();
		$banner = new BannerLogic();

        if ($this->request->isPost())
        {
            $param['show_status'] = isset($param['show_status']) ? 1 : 0;

            if ($banner->where('id', $param['id'])->save($param))
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
			return view('',['editData'=>$banner->getBannerInfo($param['id'])]);
        }

	}
}