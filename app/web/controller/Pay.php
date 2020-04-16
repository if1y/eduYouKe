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
        if (!$check) {
        	//商品为空跳转
        	$this->error('操作有误');
        }
        $result = $service->pay($param);
        $this->success('正在跳转...','',['mobile'=>$param['isMobile'],'src'=> $result]);
    }

}
