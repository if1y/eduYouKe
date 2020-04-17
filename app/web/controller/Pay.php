<?php
namespace app\web\controller;
use app\UserBaseController;
use app\logic\Course;
use app\logic\Order;
use think\facade\View;
use app\service\Pay as PayService;


class Pay extends UserBaseController
{
    //支付
    public function pay()
    {   
        $service = new PayService();
        $param   = $this->request->param();
        $param['isMobile']  = $this->request->isMobile() ? 1:2;
        //检测商品是否存在
        
        $order = new Order();

        $check = $order->getCommodityInfo($param);
        // print_r($check);exit();
        if (!$check) {
        	//商品为空跳转
        	$this->error('操作有误');
        }

        $orderId = $order->createOrder($param);

        $result = $service->pay($param);
        
        $this->success('正在跳转...','',[
            'mobile'=>$param['isMobile'],
            'order_id'=>$orderId,
            'src'=> $result
        ]);
    }

    //查询订单状态
    public function payStatus()
    {
        $param   = $this->request->param();
        $order = new Order();
        $result = $order->getOrderInfo([
            'order_no'=>$param['order_id'],
            'order_status'=>1
        ]);

        return $result ? $this->success('支付成功') : $this->error('未成功');
    }

}
