<?php
namespace app\logic;
use think\facade\Session;
use app\util\Tools;

use app\model\User as UserModel;


class User extends UserModel
{
    //获取验证码
    public function getMobileCode($param)
    {

        if (!checkMobile($param['mobile']))
        {
            return 1;
        }
        //检测手机号是否注册
        $info = $this->getUserInfo(['mobile' => $param['mobile']]);
        $code = getRoundCode();

        //查询当天手机号发送的次数
        $log  = new RecordLog();

        $count = $log->where([
            'category'=>'smsCode',
            'key'=>$param['mobile']]
        )->whereDay('create_time')->count();

        if ($count >= 5) {
            return 2;
        }
        $log->save(
            [
                'key'=>$param['mobile'],
                'category'=>'smsCode',
                'value'=>$code,
                'create_time'=>time()
            ]);


        //检测今天发送次数
        if (!empty($info))
        {
            //更新用户最后登录
        }
        else
        {
            // 新增当前手机号为用户
            $this->save(
                [
                    'mobile'=>$param['mobile'],
                    'nickname'=>'昵称_'.$code,
                    'password'=>Tools::userMd5($code),
                    'last_login_ip'=>$param['ip'],
                    'last_login_time'=>time(),
                    'create_time'=>time(),
                    'update_time'=>time(),
                ]);
        }

        return $code;
    }

    //用户登录
    public function doLogin($param)
    {
        if ($param['type']) {
            //手机号验证码登录
            return $this->mobileLogin($param);
        }else{
            // 账号密码登录
            return $this->nicknameLogin($param);
        }
    }

    //昵称/手机号登录
    public function nicknameLogin($param)
    {
        // print_r($param);exit();
        $whereOr = [
            ['mobile', '=', trim($param['username'])],
            ['nickname', '=', trim($param['username'])],
        ];

        $userInfo = $this->whereOr($whereOr)->find();
        if (empty($userInfo)) {
            return 2; //暂无此用户
        }
        // print_r(Tools::userMd5($param['password']));exit();
        if ($userInfo['password'] == Tools::userMd5($param['password'])) {
            
            $this->updateExperience($userInfo);
            Session::set('UserInfo',json_encode($userInfo));
            return 1;
        }
        return 5;

    }

    //
    public function updateExperience($userInfo)
    {

        $log = new RecordLog();
        $result = $log->where([
            'category'=>'loginExperience','user_id'=>$userInfo['id']
        ])->whereDay('create_time')->find();

        if (empty($result)) {
            $log->baseSave('loginExperience',$userInfo['id']);
            $this->where('id',$userInfo['id'])->inc('empirical',1000)->update();
        }

    }


    //手机号登录
    public function mobileLogin($param)
    {
        $userInfo = $this->getUserInfo(['mobile' => $param['mobile']]);
        if (empty($userInfo)) {
            return 2; //暂无此用户
        }
        $log  = new RecordLog();
        $content = $log->field('value,create_time')
        ->where(['category'=>'smsCode','key'=>$param['mobile'],'value'=>$param['smscode']])
        ->order('create_time','desc')->find();
        if (empty($content)) {
            return 3; //验证码有误
        }

        //
        if ( (time() - strtotime($content['create_time'])) > 360 ) {
            return 4; //验证码无效
        }

        Session::set('UserInfo',json_encode($userInfo));
        $this->updateExperience($userInfo);

        return 1;


    }

    //根据用户ID更新session
    public function updateSession($admin,$column,$value)
    {

        $key = $admin ? 'adminUserInfo' :'UserInfo';
        $userInfo  = Session::get($key);

        if (!empty($userInfo)) {
            $info = json_decode($userInfo,true);
            $info[$column] = $value;
            Session::set($key,json_encode($info));
        }

    }

}
