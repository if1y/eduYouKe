<?php
declare (strict_types = 1);
namespace app;

use app\BaseController;
use think\facade\DB;
use think\facade\View;
use think\facade\Env;
use app\util\Nav;
use app\util\Tools;
use think\facade\Request;
use think\facade\Session;


class UserBaseController extends WebBaseController
{

    protected $userId;

    // 初始化
    protected function initialize()
    {
        //获取当前配置的模板
        parent::initialize();
        $this->getUserId();
    }


    public function getUserId()
    {

        $userId = getUserInfoData();
        if (empty($userId)) {
            if ($this->request->isAjax()) {
                return json(['code'=>0,'message'=>'您尚未登录']);
                // $this->error("您尚未登录", cmf_url("user/Login/index"));
            } else {
                header('location:/login/login');exit();
            }
        }
        $this->userId = $userId;

    }


    public function getUserCentor()
    {
        $userId = getUserInfoData();
        $mySelf = 1;

        $request = Request::instance();
        $param = $request->param();
        if (isset($param['user_id'])) {
            //判断是否为本人
            $mySelf = $userId == $param['user_id'] ? 1 : 0;
            $userId = $param['user_id']; 
        }
        if (empty($userId)) {
            Session::set('UserInfo','null');
        }
        $userInfo = DB::name('user')->where('id',$userId)->find();
        $userInfo['myself'] = $mySelf;
        return $userInfo;
    }

    

}
