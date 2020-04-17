<?php
namespace app\service;

class AliPay
{
    //
    public function pay($data)
    {

        $aliConfig = config('AliPay');
        $tradeNo   = time() . rand(1000, 9999);
        $payData   = [
            'body' => $data['title'],
            'subject' => $data['title'],
            'trade_no' => $data['order_no'],
            'time_expire' => time() + 1000, // 表示必须 1000s 内付款
            'amount' => $data['amount_total'], // 单位为元 ,最小为0.01
            'return_param' => $data['user_id'],
            // 'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',// 客户地址
            'goods_type' => '1', // 0—虚拟类商品，1—实物类商品
            'store_id' => '',
            // 'verify' => false,
            'operator_id' => '',
            'terminal_id' => '', // 终端设备号(门店号或收银设备ID) 默认值 web
        ];

        // 使用
        try {
            
            $client = new \Payment\Client(\Payment\Client::ALIPAY, $aliConfig);
            switch ($data['isMobile']) {
                case '1':
                    $res    = $client->pay(\Payment\Client::ALI_CHANNEL_WAP, $payData);
                    break;
                default:
                    $res    = $client->pay(\Payment\Client::ALI_CHANNEL_QR, $payData);
                    break;
            }
            return isset($res['qr_code']) ? $res['qr_code'] :$res;
        }
        catch (InvalidArgumentException $e)
        {
            echo $e->getMessage();
            exit;
        }
        catch (\Payment\Exceptions\GatewayException $e)
        {
            echo $e->getMessage();
            var_dump($e->getRaw());
            exit;
        }
        catch (\Payment\Exceptions\ClassNotFoundException $e)
        {
            echo $e->getMessage();
            exit;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            exit;
        }

        return $res['qr_code'];
        return  \Payment\Helpers\StrUtil::toQRImg($res['qr_code']);

    }
}
