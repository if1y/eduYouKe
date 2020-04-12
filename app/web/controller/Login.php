<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;
use app\logic\User;
use think\facade\Session;



class Login extends WebBaseController
{

    //获取验证码
    public function getSmsCode()
    {
        $param       = $this->request->param();
        $param['ip'] = $this->request->ip();

        //查询手机号是否注册
        if (isset($param['mobile']))
        {
            $user   = new User();
            $result = $user->getMobileCode($param);

            switch ($result)
            {
                case 1:
                    $json = ['code' => 0, 'message' => '手机号有误'];
                    break;
                case 2:
                    $json = ['code' => 0, 'message' => '今日发送次数较多...'];
                    break;
                default:
                    // $json = ['code' => 1, 'message' => '验证码获取成功'];
                    $json = ['code' => 1, 'message' => '验证码获取成功', 'smscode' => $result];
                    break;
            }

        }
        else
        {

            $json = ['code' => 0, 'message' => '请输入手机号'];

            //
        }
        return json($json);

    }

    //登录验证
    public function doLogin()
    {
        $param       = $this->request->param();
        $param['ip'] = $this->request->ip();
        $user   = new User();
        $result = $user->doLogin($param);
        switch ($result) {
            case 1:
                $json = ['code' => 1, 'message' => '登录成功'];
                break;
            case 2:
                    $json = ['code' => 0, 'message' => '暂无此用户...'];
                break;
            case 3:
                    $json = ['code' => 0, 'message' => '验证码有误...'];
                break;
            case 4:
                    $json = ['code' => 0, 'message' => '验证码无效...'];
                break;
            
            default:
                    $json = ['code' => 0, 'message' => '账号或密码有误'];
                break;
        }

        return json($json);

    }

	//登录
    public function login()
    {
        return View::fetch('');
    }

    // 注册
    public function register()
    {
        return View::fetch('');
    }

    // 忘记密码
    public function forget()
    {
        return View::fetch('');
    }


    // 忘记密码
    public function logout()
    {
        Session::set('adminUserInfo', null);
    	return redirect('/');
    }


}
