<?php
namespace app\logic;

use app\model\User as UserModel;
use app\service\AliSms;
use app\util\Tools;
use think\facade\Db;
use think\facade\Session;

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
        $log = new RecordLog();

        $count = $log->where([
            'category' => 'smsCode',
            'key' => $param['mobile']]
        )->whereDay('create_time')->count();

        if ($count >= 5)
        {
            return 2;
        }

        //发送短信添加log
        event('LogSendSMS', ['mobile' => $param['mobile'], 'code' => $code]);

        //检测今天发送次数
        if (!empty($info))
        {
            //更新用户最后登录
            event('UserLogin', ['user_id' => $info['id'], 'ip' => $param['ip']]);
        }
        else
        {
            // 新增当前手机号为用户
            $this->save(
                [
                    'mobile' => $param['mobile'],
                    'nickname' => '昵称_' . $code,
                    'password' => Tools::userMd5($code),
                    'last_login_ip' => $param['ip'],
                    'last_login_time' => time(),
                    'create_time' => time(),
                    'update_time' => time(),
                ]);
        }

        $aliSms = new AliSms();
        $res    = $aliSms->sendSms(array_merge($param, ['code' => $code]));
        
        return !$res ? 3 : $code;
    }

    //用户登录
    public function doLogin($param)
    {
        if ($param['type'])
        {
            //手机号验证码登录
            return $this->mobileLogin($param);
        }
        else
        {
            // 账号密码登录
            return $this->nicknameLogin($param);
        }
    }

    //昵称/手机号登录
    public function nicknameLogin($param)
    {
        // print_r($param);exit();
        $whereOr = [
            ['mobile', '=', trim($param['nickname'])],
            ['nickname', '=', trim($param['nickname'])],
        ];

        $userInfo = $this->whereOr($whereOr)->find();
        if (empty($userInfo))
        {
            return 2; //暂无此用户
        }
        // print_r(Tools::userMd5($param['password']));exit();
        if ($userInfo['password'] == Tools::userMd5($param['password']))
        {

            $this->updateExperience($userInfo);
            Session::set('UserInfo', json_encode($userInfo));
            return 1;
        }
        return 5;

    }

    //
    public function updateExperience($userInfo)
    {

        $log    = new RecordLog();
        $result = $log->where([
            'category' => 'loginExperience', 'user_id' => $userInfo['id'],
        ])->whereDay('create_time')->find();

        if (empty($result))
        {
            $log->baseSave('loginExperience', $userInfo['id']);
            $this->where('id', $userInfo['id'])->inc('empirical', 1000)->update();
        }

    }

    //手机号登录
    public function mobileLogin($param)
    {
        $userInfo = $this->getUserInfo(['mobile' => $param['mobile']]);
        if (empty($userInfo))
        {
            return 2; //暂无此用户
        }
        $log     = new RecordLog();
        $content = $log->field('value,create_time')
            ->where(['category' => 'smsCode', 'key' => $param['mobile'], 'value' => $param['smscode']])
            ->order('create_time', 'desc')->find();
        if (empty($content))
        {
            return 3; //验证码有误
        }

        //
        if ((time() - strtotime($content['create_time'])) > 300)
        {
            return 4; //验证码无效
        }

        Session::set('UserInfo', json_encode($userInfo));
        $this->updateExperience($userInfo);

        return 1;

    }

    //根据用户ID更新session
    public function updateSession($admin, $column, $value)
    {

        $key      = $admin ? 'adminUserInfo' : 'UserInfo';
        $userInfo = Session::get($key);

        if (!empty($userInfo))
        {
            $info          = json_decode($userInfo, true);
            $info[$column] = $value;
            Session::set($key, json_encode($info));
        }

    }

    //
    public function register($param)
    {
        // print_r($param);exit();
        $userInfo = $this->getUserInfo(['nickname' => $param['nickname']]);
        if (!empty($userInfo))
        {
            return 2;
        }
        //
        if ($param['password'] == $param['repassword'])
        {
            //注册并登录

            $this->save(
                [
                    'nickname' => $param['nickname'],
                    'password' => Tools::userMd5($param['password']),
                    'last_login_ip' => $param['ip'],
                    'last_login_time' => time(),
                    'create_time' => time(),
                    'update_time' => time(),
                ]);

            $userInfo = $this->getUserInfo(['nickname' => $param['nickname']]);
            if ($userInfo)
            {
                Session::set('UserInfo', json_encode($userInfo));
                return 1;
            }

        }
        else
        {
            return 3;
        }
    }

    //忘记密码
    public function forget($param)
    {
        $userInfo = $this->getUserInfo(['mobile' => $param['mobile']]);
        if (empty($userInfo))
        {
            return 2; //暂无此用户
        }
        $log     = new RecordLog();
        $content = $log->field('value,create_time')
            ->where(['category' => 'smsCode', 'key' => $param['mobile'], 'value' => $param['smscode']])
            ->order('create_time', 'desc')->find();
        if (empty($content))
        {
            return 3; //验证码有误
        }

        //
        if ((time() - strtotime($content['create_time'])) > 300)
        {
            return 4; //验证码无效
        }

        return $this->where('id', $userInfo['id'])->save([
            'password' => Tools::userMd5($param['password']),
        ]);

    }

    //获取用户历史足迹
    public function getUserHistory($param)
    {
        $userId = isset($param['user_id']) ? $param['user_id'] : getUserInfoData(0, 'id');

        $arr = ['courseView', 'comment'];

        $whereOr = [];
        foreach ($arr as $key => $value)
        {
            $whereOr[$key] = ['log.category', '=', $value];
            $whereOr[$key] = ['log.category', '=', $value];
        }

        // print_r($whereOr);

        $result = $this->alias('u')
            ->field([
                'log.*',
                'c.url',
                'c.content',
            ])
            ->join('record_log log', 'u.id = log.user_id')
            ->join('comment c', 'c.id = log.key')
            ->order('log.create_time', 'desc')
            ->whereOr($whereOr)
            ->where(['c.show_status' => 1, 'c.delete_status' => 0])
            ->where('log.user_id', $userId)
            ->paginate(['query' => ['user_id' => $userId], 'list_rows' => 3])->each(function ($item)
        {
            // print_r($item);exit();
            $item['source_id'] = $item['key'];
            switch ($item['category'])
            {

                case 'courseView':

                    $result = DB::name('course')
                        ->where('id', $item['key'])->find();
                    $title = $result['title'];
                    $image = $result['cource_image_url'];

                    break;
                default:

                    break;
            }

            $item['title']          = isset($title) ? $title : '';
            $item['image']          = isset($image) ? $image : '';
            $item['recent_updates'] = Tools::getDate(strtotime($item['create_time']));
            return $item;
        });
        return $result;
    }

    //获取后台用户列表
    public function getUserList($where = [], $field = '*')
    {
        return $this->field($field)->where($where)
            ->where(['delete_status' => 0])->order('create_time desc')->paginate();
    }

}
