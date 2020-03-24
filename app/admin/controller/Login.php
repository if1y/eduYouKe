<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\User;
use think\facade\Session;
use think\facade\View;

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
        if (!captcha_check($param['verifycode']))
        {
            $this->error('验证码错误');
        }
        $user   = new User();
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
        Session::set('adminUserInfo', null);
        return json(['code' => 1, 'msg' => '退出成功']);
    }

}
