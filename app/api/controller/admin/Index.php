<?php
namespace app\api\controller\admin;

use app\AdminApiBaseController;
use app\logic\Index as indexLogic;
use think\facade\View;

class Index extends AdminApiBaseController
{
    // protected $middleware = ['adminAuthApi','AccessApi'];

    public function index()
    {
    	return json([
    		'data'=>1
    	]);
        // $index = new indexLogic();
        //获取基础信息
        // return view('', [
        //     'basecount' => $index->getAdminCount(),
        // ]);
    }
}
