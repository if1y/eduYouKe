<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\AdminUser;
use think\facade\Session;
use think\facade\View;
use app\admin\validate\Login as LoginValidate;



class Login extends AdminBaseController
{
    
    //
    public function initialize()
    {
        $this->getWebTheme();
        View::assign('templateName', $this->template);

    }
    //登录
    public function login()
    {
        return View::fetch('');
    }

    //登录
    public function doLogin()
    {
        $param = $this->request->param();
        //验证数据
        $validate = new LoginValidate();
        if (!$validate->check($param))
        {
            $this->error($validate->getError());
        }

        $user   = new AdminUser();
        $result = $user->doLogin($param);
        switch ($result)
        {
            case 1:
                return json(['code' => 1, 'msg' => '登录成功']);
                break;
            default:
                return json(['code' => 0, 'msg' => '账号密码错误']);
                break;
        }
    }

    // 退出登录
    public function logout()
    {
        Session::delete('adminUserInfo');
        return json(['code' => 1, 'msg' => '退出成功']);
    }

}
