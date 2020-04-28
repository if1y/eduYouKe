<?php
namespace app\vod\controller;

use app\logic\Order;
use app\service\Pay as PayService;
use app\WebBaseController;
use think\facade\Log;



class Pay extends WebBaseController
{
    protected $middleware = [ 
        'auth' => ['only'      => ['pay','payStatus'] ],
    ];

    
    //支付
    public function pay()
    {
        $service           = new PayService();
        $param             = $this->request->param();
        $param['isMobile'] = $this->request->isMobile() ? 1 : 2;
        //检测商品是否存在
        
        $order = new Order();

        $check = $order->getCommodityInfo($param);

        if (!$check)
        {
            //商品为空跳转
            $this->redirect('/');
        }

        $orderId = $order->createOrder($param);

        $orderInfo = $order->getOrderInfo(['order_no' => $orderId]);
        $result    = $service->pay(array_merge([
            'title' => $check['title'],
            'payType' => $param['payType'],
            'isMobile' => $param['isMobile'],
        ], $orderInfo->toArray()));

        $this->success('正在跳转...', '', [
            'mobile' => $param['isMobile'],
            'order_id' => $orderId,
            'src' => $result,
        ]);
    }

    //查询订单状态
    public function payStatus()
    {
        $param  = $this->request->param();
        $order  = new Order();
        $result = $order->getOrderInfo([
            'order_no' => $param['order_id'],
            'order_status' => 1,
        ]);

        return $result ? $this->success('支付成功') : $this->error('未成功');
    }

    //统一支付回调接口
    public function notify()
    {
        $param  = $this->request->param();
        Log::record('测试日志信息');
    }

}
