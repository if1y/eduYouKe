<?php
namespace app\web\controller;
use app\UserBaseController;
use app\logic\Course;
use think\facade\View;
use app\service\Pay as PayService;


class Pay extends UserBaseController
{
    //支付
    public function pay()
    {   
        $service = new PayService();
        $param   = $this->request->param();
        $result = $service->pay($param);
        $this->success('success','',['src'=> $result]);
    }

}
