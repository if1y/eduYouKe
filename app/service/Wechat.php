<?php

namespace app\service;

use app\logic\Setting;

class Wechat
{
    //获取微信code
    public function getWecahtCode()
    {
        $redirect_uri = urlencode(getDomain() . '/user/login/login');
        $setting      = new Setting();
        $AppId        = $setting->getSettingContent('wechatPayAppId');
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$AppId}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base";
    }

    //
    public function accessToken()
    {
        $setting = new Setting();

        $AppId     = $setting->getSettingContent('wechatPayAppId');
        $AppSecret = $setting->getSettingContent('wechatPayAppSecret');

        //获取
        $uri  = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$APPSECRET}";
        $data = curlGet($uri);
        return json_decode($data, true)['access_token'];

    }

    //$code获取openid
    public function getWechatOpenId($code)
    {

        $AppId     = $setting->getSettingContent('wechatPayAppId');
        $AppSecret = $setting->getSettingContent('wechatPayAppSecret');
        $open      = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$AppId}&secret={$AppSecret}&code={$code}&grant_type=authorization_code";

        $data   = curlGet($open);
        $result = json_decode($data, true);
        $openid = $result['openid'];

    }

}
