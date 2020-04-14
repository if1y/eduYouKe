<?php

namespace app\api\service;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class WxPay
{
    public function getConfig()
    {
        return [
            'appid' => 'wx28193cfede2af7c7', // APP APPID
            'app_id' => '', // 公众号 APPID
            'miniapp_id' => '', // 小程序 APPID
            'mch_id' => '1552699601',
            'key' => 'rydlRgXiBf0LaZ6EdCZk3fKPalhHySJy',
            'notify_url' => get_domain() . '/php/api/order/WxPayCallback',
            'cert_client' => '', // optional，退款等情况时用到
            'cert_key' => '',// optional，退款等情况时用到
            'log' => [ // optional
                'file' => '../runtime/paylogs/wxpay.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            'mode' => 'normal', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
        ];
    }

    /*protected $config = [
        'appid' => 'wx1c81e5faf1e98e68', // APP APPID
        'app_id' => '', // 公众号 APPID
        'miniapp_id' => '', // 小程序 APPID
        'mch_id' => '1227780702',
        'key' => '0ExkGk2OgMTqauWZI0havyp4zxzaKYXy',
        'notify_url' => '/php/api/order/WxPayCallback',
        'cert_client' => '', // optional，退款等情况时用到
        'cert_key' => '',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => '../runtime/paylogs/wxpay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'normal', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ];*/

    public function index($data)
    {
        $order = [
            'out_trade_no' => $data['order_code'],
            'total_fee' => $data['actual_price'] * 100,
            'body' => $data['name'],
            'time_expire' => date('YmdHis',getOrderOverTime() + time()),
        ];

        $pay = Pay::wechat($this->getConfig())->app($order);
        if ($pay->getStatusCode() == '200') {
            return $pay->getContent();
        } else {
            return false;
        }

        // $pay->appId
        // $pay->timeStamp
        // $pay->nonceStr
        // $pay->package
        // $pay->signType
    }

    public function notify()
    {
        $pay = Pay::wechat($this->getConfig());

        try {
            $data = $pay->verify(); // 是的，验签就这么简单！

            $data = $data->all();

            recordLog('','微信支付Data数据:'.json_encode($data));

            Log::info('Wxpay 1', ['ceshi'=>$data]);

            if ($data['return_code'] == 'SUCCESS') {
                return ['order_code'=>$data['out_trade_no'],'actual_price'=>$data['total_fee'] / 100];
            }else{
                recordLog('','微信支付!=SUCCESS:'.json_encode($data));
            }

            //Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();

            recordLog('','微信支付error:');

            Log::error('Wxpay notify errorMessage', ['error'=>$e->getMessage()]);
            return false;
        }

        //return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }
}