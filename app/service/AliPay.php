<?php

namespace app\api\service;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class AliPay
{
    public function getConfig()
    {
        return [
            'app_id' => '2019082466431101',//正式
            //'app_id' => '2016101100657898',//沙箱
            'notify_url' => get_domain() . '/php/api/order/AliPayCallback',//回调地址
            'return_url' => '',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAp45w08UNb4dK/YXrAL5NyiXM76F2rP1tcPZARPCIF+NvVZfYKZrBaPNUTUMSRYUqh7KcKtrXODY/++3H6Eb9FGwzshjfdHfINgXza15YFJXxoos40LexekbmrosglrgfhZA5hU+DVQZszEfxpZZ0HIWmyXeWujM93kEZPxasaaF3S4cYm01SLbOpZPfnedQUdfOFTFXOgpSMXhS9GfzOc/fDVYzBSrYcesZO3lY7xjN+HJNcND1vPqqFEUMxOND2WwOCF3zdlbY+h1btu9w2ez2y/v0dRaDytLrlCakBN6CcbTEcDJa/l1bgJx5I2XI9rAq4zNtTScwKviNPNiyEOQIDAQAB',//正式(支付宝公钥，不是应用公钥！！！！！！！！！！！！！)
            //'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjgXiEcH4SWv1nqmWYCd506IIbjAwjIwOZVTcC9RwiEIjl0PLIYno9Sql0MWin13vYn+u2RcJLNw2n/7lw0GMyqJAHJQSTJtYm2Cj/U9BF2nRHnhxdcXC4io/r/I6NohF/zetHFFDDo3QX4rqPes5KzxZhqBSVADgvh75XkZbSZ0yBownynuSlW/BIrbqvhxzGoxjnLpveGYpuQwMDshoqNem8uDu8LDtI2XBnsSHMWl3pAokYa8jrA4DJBtPWLvM0XfTv9XAwan8WwWv7LO7s2s5fDbXjalMPhhzfbonPPsNCG8AIZiuxzyTNw1iMd8YyzrdQhejLZM+K+vel2JcVQIDAQAB',//沙箱(支付宝公钥，不是应用公钥！！！！！！！！！！！！！)
            // 加密方式： **RSA2**
            'private_key' => 'MIIEowIBAAKCAQEAxGZhiEfglw7yfyxA02Ljn9eitwMAAORbDme0sZHdkNqInrEJ4myth6UQqQXvPPEPYE+L+e62/zdDyHwLkV3+3/VVCM+pl4kimBvymY8E8U17yF2TDxUT6MXNqJlN/IUkVHQBK6M9JcTNFCVQ1YLsZzaPB1Nhq8QnmELq2sVEQqTpUBl/JATsB2dVg+ScnuLgfvJ6WOIYfWqqogPH28sRtgRAzE5BVqmxEGSiRLEd5hrvOAmSBH4f4QTOjQL7kgoJKgnRPAFBAjNLgVOWBfkhB/Jwat+l/BQObpJIE18QbvKIA+AOPxjxrHeZmVpfEW0i/0PT9lEQA4mCc1AKBbytkwIDAQABAoIBAQCxBEoyJ/6wiENfBkbjgAUDo7q/0w9kvm2nvScqyPr3vVBYH9912lhJoygx/+xSdD9Uoj3apiMAQxJwGAXhHuRDfX8IMwt7TpoEmWP+rd5Zk2nW/Sg39tp7+hTUOmEFEgfdqrUHXNkXOptQ5hVGa/uhR5aAltG4nFLHtMCzMAvHOAG5bXtQUI58j6XabNmz27dzyRr8EMOa4QKnAMl+KCiIysF/RCKeqpSC/chvaGQVKEtCh8d71X1w/S2WBp3neEikebQS+VKjsEbpg9hTdTmMi+2mDX/Oeoi4OaNZ8WCLpNH8lw+sX4tZyblIiUcixoXQbtawozk9v3xZuusfpauZAoGBAOfFJCWm4B38cKx5xCPGNZIkLGYgcDKxkdOeCv2lvvnhtydM+b9rwGAEH8mUPpIU4cOdZDKntFMrbI/ijq5+tYMkVPPlrglwNVAWNZRXfY32zDpKGS7ZkUhBeU9jZry4AgzMkb2gC/VcNMZKHx+Hne81k6GOdFc8+UUuhk0Y8++VAoGBANjuoP20wdLNC1cHUL854WpsVRTypfd67iAzyBv1KVBM6I5M9WeReu5XLesOOJqbRwdD1UrkBhv1DbRScu6OichS1NMognDqpaQteQCLdlkGG9Szo1KAFTmTi59lxktPoVmXfP+rqVZMEd+hM17dFkfAAxvFnj6dn0O75VZE9n6HAoGAE2pOVuEd0SU+gxRIO/70qeNh3MRG4dhCMQoCPbFOyDwCTcaC/WgXW3O8/fPvMemR6AMdS6kE0BrJI1yFO1Td+7hlbXEGHUBLFwRlRKH3oJbWEOP4LBaJtxXVBbN7/b8kXNIeO1ZW6hzpRtsatFd2AX3pehUm5c/zybnWAkte0+kCgYB8tdK/h6bVtSMLyRzWkkPQlq7i+AwJlhZHVP15dRtnGo+nHv8Fp1DwrBWtx+MqnpHaz1hTUXthnyNdwvhnxHHZRCUtr2At4fePxsSFV6eVzjk5snv19cQ98WCXJj81FHZBtyEZKmqTPfAYi+eoZZllbjFbSeSLQrpIikBxs/uxCQKBgAaxI6umFKXJVAWi0dqYhq1E9dAIKUMNV+VaR2YmwmeCOszDMmMZliW8roe+z0dbKdgsxrywf/3QONHJIQnujI0TLWAfiYdqRkOsLZj8S0w+WDHL6KLV5kenOrqJEnMA+uf9SDNA0eYgJyCfTVHA4ws1XGTMX30WNBZ3PhRhvasq',//正式
            //'private_key' => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCJwDi6mXRlqqiFwDbYe012OI7mq226h2Y2eUmYwjYMjxobq6WuR+/w81Ht2j52XkCH2oD8Opkv5ydSt/qcc50qSEuzJ6BfIUcDY+o8MfcbOCuuAp54ymeMVPMK2QTv1wA9dqmW3DdtaAT6friD1X5D4Us3AUrVoeyflmXObu4RgitSD2pze4Q2ibGMLPAfI6z99SPk6yvh2MekUy3yw6+Nf0TEQxGbkGylo5iqMZeUmUhqq/6mK1tXBaEnWl0e02laqU3DDBlhpK9NizsU4d+cS3RY2b+bYn4JxvKGiEqlaWfuk7JsOLuUdIHaGbtE1kxh8t7Ft7eKETpxMh1yGkJTAgMBAAECggEAIby9aB47XscMXS21gRG56BF0FlS4HC4bP443Ez3FpQ/LUimY+3VM89N0JnAESlNNNLi0TJJBgHT5sY2zyGuce4WXXLqA0avBy7fF35ZRMg5wzD6B942DDOClYevDBMbAnU0ZvgQTYy1NwtgUct1v/koIdOFRJb9xx6g7KPMMRaci2nza8+lNTwfRCXWJHCSr98jvkst3VsqBeqZG1rJQgGY93CdkonBGgCEgDs/9kXgOjcYPvhjKjdCVWXU5asApHz7WKSr+TkLZFP2GTfBXXnHryG9MUJ26DUjL6mt9K6uW/ixN273n91EKvvtlTNwniBGxS0ypNYjleSStc7s5sQKBgQC/ZGEbJQC826UmSzwybBFcrp/etHj2xQo2GX9EngfiGoCisZNoR14ko5H88UOBKoU8Rh6/7tYhbhYwH3NbQN47PJEd53kUBa02jDe6qQo/OyXFV/0FrzNzDbmgG5GOIs59e7WORa1KM238rsc1SMlVmBwWDxYUA/RQqrFHoejN6QKBgQC4QE1dH0xEeI5isMhhbDqVZPYxDLw9yOadlNkF+eJ99pA6lqlVP2JaYAPrwZsIwSqtzmJx9VGcf3ouQEYEuOohIOLg3Ide2I8gdpQnpA2Dh+Ynip0kFOKm1vDVY46UNEAvuD3qWZ4fv2WDLNnpS8HefooYPG38vYjbY30LtwO82wKBgB73su6dch0cvQARNFBERBrm9l8mfFwRTbGrNnh3yXbAKwgoC13YDleHT9vJfc6sfppeDiOoFWWbVmO68wNU36BeEGzyQxkGQhyNW4cMSugoPdhMgFgnHQAEvIA3dbm10AtltN6sT3muEKHN9dWdTVZYIlM/ZacfbKyQsdaRUAXhAoGBAIiezX62XWQMDHAra3mpucra4R4/tjkOBcpk+4NN5d7G++0lmAvpAvHGbkHa/i1ApnfYJ/EeGVS0xZEUAZcw0hKcgv5/JzVx2LcWlgbKw2Z7V3KMeratcd6KVGu19Zv5HnsD340sxG4ACrJ4iGBP10I2jAkqjdexZpBetfMA0pmvAoGBAKDW5hzMW9P8ljLtpdPZpDEmGhicLrLfqH8x0STNZSX/3WdkR8exsBhjvmSWWxWzQw2UV1B4grJVpMsrdhtCN1pJ7D5vQe8dsD/GSIFv3Adre0ujRR+qRaR6DsEMEjz6RaqlOo/YQeP7EacdrTJrIgwEUBAwNWS6nC9yfokzx6VE',//沙箱
            'log' => [ // optional
                'file' => '../runtime/paylogs/alipay.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            'mode' => 'normal', // optional,设置此参数，将进入沙箱模式normal
        ];
    }

    /*protected $config = [
        //'app_id' => '2019072565949691',//正式
        'app_id' => '2016101100657898',//沙箱
        'notify_url' => 'http://111.206.87.233:8888/api/order/AliPayCallback',//回调地址
        'return_url' => '',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjgXiEcH4SWv1nqmWYCd506IIbjAwjIwOZVTcC9RwiEIjl0PLIYno9Sql0MWin13vYn+u2RcJLNw2n/7lw0GMyqJAHJQSTJtYm2Cj/U9BF2nRHnhxdcXC4io/r/I6NohF/zetHFFDDo3QX4rqPes5KzxZhqBSVADgvh75XkZbSZ0yBownynuSlW/BIrbqvhxzGoxjnLpveGYpuQwMDshoqNem8uDu8LDtI2XBnsSHMWl3pAokYa8jrA4DJBtPWLvM0XfTv9XAwan8WwWv7LO7s2s5fDbXjalMPhhzfbonPPsNCG8AIZiuxzyTNw1iMd8YyzrdQhejLZM+K+vel2JcVQIDAQAB',//沙箱(支付宝公钥，不是应用公钥！！！！！！！！！！！！！)
        // 加密方式： **RSA2**
        'private_key' => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCJwDi6mXRlqqiFwDbYe012OI7mq226h2Y2eUmYwjYMjxobq6WuR+/w81Ht2j52XkCH2oD8Opkv5ydSt/qcc50qSEuzJ6BfIUcDY+o8MfcbOCuuAp54ymeMVPMK2QTv1wA9dqmW3DdtaAT6friD1X5D4Us3AUrVoeyflmXObu4RgitSD2pze4Q2ibGMLPAfI6z99SPk6yvh2MekUy3yw6+Nf0TEQxGbkGylo5iqMZeUmUhqq/6mK1tXBaEnWl0e02laqU3DDBlhpK9NizsU4d+cS3RY2b+bYn4JxvKGiEqlaWfuk7JsOLuUdIHaGbtE1kxh8t7Ft7eKETpxMh1yGkJTAgMBAAECggEAIby9aB47XscMXS21gRG56BF0FlS4HC4bP443Ez3FpQ/LUimY+3VM89N0JnAESlNNNLi0TJJBgHT5sY2zyGuce4WXXLqA0avBy7fF35ZRMg5wzD6B942DDOClYevDBMbAnU0ZvgQTYy1NwtgUct1v/koIdOFRJb9xx6g7KPMMRaci2nza8+lNTwfRCXWJHCSr98jvkst3VsqBeqZG1rJQgGY93CdkonBGgCEgDs/9kXgOjcYPvhjKjdCVWXU5asApHz7WKSr+TkLZFP2GTfBXXnHryG9MUJ26DUjL6mt9K6uW/ixN273n91EKvvtlTNwniBGxS0ypNYjleSStc7s5sQKBgQC/ZGEbJQC826UmSzwybBFcrp/etHj2xQo2GX9EngfiGoCisZNoR14ko5H88UOBKoU8Rh6/7tYhbhYwH3NbQN47PJEd53kUBa02jDe6qQo/OyXFV/0FrzNzDbmgG5GOIs59e7WORa1KM238rsc1SMlVmBwWDxYUA/RQqrFHoejN6QKBgQC4QE1dH0xEeI5isMhhbDqVZPYxDLw9yOadlNkF+eJ99pA6lqlVP2JaYAPrwZsIwSqtzmJx9VGcf3ouQEYEuOohIOLg3Ide2I8gdpQnpA2Dh+Ynip0kFOKm1vDVY46UNEAvuD3qWZ4fv2WDLNnpS8HefooYPG38vYjbY30LtwO82wKBgB73su6dch0cvQARNFBERBrm9l8mfFwRTbGrNnh3yXbAKwgoC13YDleHT9vJfc6sfppeDiOoFWWbVmO68wNU36BeEGzyQxkGQhyNW4cMSugoPdhMgFgnHQAEvIA3dbm10AtltN6sT3muEKHN9dWdTVZYIlM/ZacfbKyQsdaRUAXhAoGBAIiezX62XWQMDHAra3mpucra4R4/tjkOBcpk+4NN5d7G++0lmAvpAvHGbkHa/i1ApnfYJ/EeGVS0xZEUAZcw0hKcgv5/JzVx2LcWlgbKw2Z7V3KMeratcd6KVGu19Zv5HnsD340sxG4ACrJ4iGBP10I2jAkqjdexZpBetfMA0pmvAoGBAKDW5hzMW9P8ljLtpdPZpDEmGhicLrLfqH8x0STNZSX/3WdkR8exsBhjvmSWWxWzQw2UV1B4grJVpMsrdhtCN1pJ7D5vQe8dsD/GSIFv3Adre0ujRR+qRaR6DsEMEjz6RaqlOo/YQeP7EacdrTJrIgwEUBAwNWS6nC9yfokzx6VE',//沙箱
        'log' => [ // optional
            'file' => '../runtime/paylogs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式normal
    ];*/

    public function index($data)
    {
        $order = [
            'out_trade_no' => $data['order_code'],
            'total_amount' => $data['actual_price'],
            'subject' => $data['name'],
            'timeout_express'=>getOrderOverTime(1).'m'
        ];

        $alipay = Pay::alipay($this->getConfig())->app($order);
        if ($alipay->getStatusCode() == '200') {
            return $alipay->getContent();
        } else {
            return false;
        }

        //return $alipay->send();// laravel 框架中请直接 `return $alipay`
    }

    public function notify()
    {
        $alipay = Pay::alipay($this->getConfig());

        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            $data = $data->all();//Log::info('Alipay 1', ['ceshi'=>$data,'aaa'=>$data['trade_status']]);
            if ($data['trade_status'] == 'TRADE_SUCCESS') {
                //Log::info('Alipay 1', ['order_code'=>$data['out_trade_no'],'actual_price'=>$data['total_amount']]);
                return ['order_code'=>$data['out_trade_no'],'actual_price'=>$data['total_amount']];
            }


            //Log::debug('Alipay notify', $data->all());
            //return $data->all();
        } catch (\Exception $e) {
            // $e->getMessage();
            //var_dump($e->getMessage());die;
            Log::error('Alipay notify errorMessage', ['error'=>$e->getMessage()]);
            return false;
        }

        //return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }
}