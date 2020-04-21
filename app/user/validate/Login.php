<?php
namespace app\user\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'nickname' => 'require',
        'password' => 'require',
        'repassword' => 'require|number',
        'clause' => 'require',
        'mobile' => 'require|mobile',
        'smscode' => 'require',
        // 'mobile' => 'mobile',
    ];

    protected $message = [
        'nickname.require' => '用户名不能为空',
        'password.require' => '密码能为空',
        'repassword.require' => '请重复输入密码',
        'clause.require' => '请选择用户条款',
        'mobile.require' => '手机号不能为空',
        'mobile.mobile' => '手机号不正确',
        'smscode.require' => '验证码不能为空',
    ];

    protected $scene = [
        'register' => ['nickname', 'password', 'repassword'],
        'forget' => ['mobile', 'password', 'smscode'],
    ];
}
