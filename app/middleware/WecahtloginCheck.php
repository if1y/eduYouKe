<?php
declare (strict_types = 1);

namespace app\middleware;

use app\logic\User;
use app\service\Wechat;
use think\facade\Session;

class WecahtloginCheck
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        //判断微信浏览器
        if (isWechat())
        {
            $wechat = new Wechat();

            if (!strpos($request->url(), 'code'))
            {
                return redirect($wechat->getWecahtCode());
            }

            $param = $request->param();

            // $accessToken = $wechat->accessToken();

            $openid = $wechat->getWechatOpenId($param['code']);
            //插入到数据库
            $userInfo = (new User())->where('openid', $openid)->find();
            if (empty($userInfo))
            {

                (new User())->insert([
                    'nickname' => '微信用户_' . getRoundCode(),
                    'password' => password_hash((string) getRoundCode(), PASSWORD_DEFAULT),
                    'openid' => $openid,
                ]);
                //
                $userInfo = (new User())->where('openid', $openid)->find();
            }
            //查询用户信息
            Session::set('UserInfo', json_encode($userInfo));
            //跳转到绑定手机号页面
            return redirect((string) url('/user/login/band', ['openid' => $openid]));

        }

        return $response;

    }

}
