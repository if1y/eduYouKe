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
                $this->error("您尚未登录",'/user/login/login');
            } else {
                header('location:/user/login/login');exit();
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
        if (empty($userInfo)) {
            header('location:/user/centor');exit();
        }
        $userInfo['myself'] = $mySelf;
        return $userInfo;
    }

    

}
