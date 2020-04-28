<?php
namespace app\vod\controller;

use app\logic\Order as OrderLogic;
use app\WebBaseController;
use think\facade\View;

class Order extends WebBaseController
{
    protected $middleware = ['auth'];

    public function createOrder()
    {

        $param = $this->request->param();

        $order = new OrderLogic();
        $info  = $order->getCommodityInfo($param);
        //查询用户是否购买
        $already = $order->getOrderStatus($param);
        if ($already)
        {
            if ($info['type'] == 'course')
            {
                redirect((string) url('course/chapter', ['id' => $info['id']]));
            }
            else
            {
                redirect((string) url('user/user/centor'));
            }
        }
        return view('', [
            'info' => $info,
        ]);
    }

}
