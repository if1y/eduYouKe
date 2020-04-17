<?php
namespace app\vod\controller;

use app\logic\User;
use app\WebBaseController;
use app\web\validate\Login as LoginValidate;
use think\facade\Session;
use think\facade\View;

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
                case 3:
                    $json = ['code' => 0, 'message' => '验证码获取失败...'];
                    break;
                default:
                    $json = ['code' => 1, 'message' => '验证码获取成功'];
                    // $json = ['code' => 1, 'message' => '验证码获取成功', 'smscode' => $result];
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
        $user        = new User();
        $result      = $user->doLogin($param);
        switch ($result)
        {
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
        $param = $this->request->param();
        if ($this->request->isPost())
        {

            // print_r($param);exit();
            $param['ip'] = $this->request->ip();
            $validate    = new LoginValidate();
            // !$validate->check($param)
            if (!$validate->scene('register')->check($param))
            {
                $this->error($validate->getError());
            }

            $user   = new User();
            $result = $user->register($param);
            switch ($result)
            {
                case 2:
                    $this->error('用户名已存在');
                    break;
                case 3:
                    $this->error('两次密码输入不一致');
                    break;

                default:
                    $this->success('注册成功');
                    break;
            }

        }
        else
        {
            return View::fetch('');
        }
    }

    // 忘记密码
    public function forget()
    {
        $param = $this->request->param();
        if ($this->request->isPost())
        {

            $param['ip'] = $this->request->ip();
            // print_r($param);exit();
            $validate = new LoginValidate();

            if (!$validate->scene('forget')->check($param))
            {
                $this->error($validate->getError());
            }

            $user   = new User();
            $result = $user->forget($param);
            switch ($result)
            {
                case 2:
                    $this->error('暂无此用户');
                    break;
                case 3:
                    $this->error('验证码有误');
                    break;
                case 4:
                    $this->error('验证码无效');
                    break;

                default:
                    $this->success('修改成功');
                    break;
            }

        }
        else
        {
            return View::fetch('');
        }
    }

    // 忘记密码
    public function logout()
    {
        Session::delete('UserInfo');
        return redirect('/');
    }

}
