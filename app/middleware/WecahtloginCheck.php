<?php
declare (strict_types = 1);

namespace app\middleware;

use app\logic\User;
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

            $redirect_uri = urlencode('http://edu.lixuqi.com/user/login/login');
            $login        = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe416e6ab1ba58105&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base";
            if (!strpos($request->url(), 'code'))
            {
                return redirect($login);
            }

            $param     = $request->param();
            $APPID     = 'wxe416e6ab1ba58105';
            $APPSECRET = 'db12dbfe673b156b766a6963c179c72e';
            //获取
            $uri   = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$APPSECRET}";
            $data  = curlGet($uri);
            $token = json_decode($data, true)['access_token'];

            $open = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$APPID}&secret={$APPSECRET}&code=" . $param['code'] . "&grant_type=authorization_code";

            $data     = curlGet($open);
            $userInfo = json_decode($data, true);
            $openid   = $userInfo['openid'];
            //插入到数据库
            (new User())->insert([
                'nickname' => '微信用户_' . mt_rand(10000, 99999),
                'password' => password_hash((string) mt_rand(10000, 99999), PASSWORD_DEFAULT),
                'openid' => $openid,
            ]);
            //查询用户信息
            $userInfo = (new User())->where('openid', $openid)->find()->toArray();
            Session::set('UserInfo', json_encode($userInfo));
            //跳转到绑定手机号页面
            return redirect((string) url('/user/login/band', ['openid' => $openid]));

        }

        return $response;

    }

}
