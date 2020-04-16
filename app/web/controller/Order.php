<?php
namespace app\web\controller;
use app\UserBaseController;
use app\logic\Order as OrderLogic;
use think\facade\View;

class Order extends UserBaseController
{
    public function createOrder()
    {
    	
        $param   = $this->request->param();

        $order     = new OrderLogic();
        $info = $order->getCommodityInfo($param);
        return view('', [
            'info' => $info
        ]);
    }


}
