<?php
declare (strict_types = 1);

namespace app\middleware;

use think\facade\Db;

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
        if (isWechat()) {

        	//获取
        	$uri = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET";
        	$data = curlGet($uri);
        	print_r($data);exit;

        }

        return $response;

	}

}


