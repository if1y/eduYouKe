<?php
namespace app\web\controller;
use app\WebBaseController;
use app\logic\Course;
use think\facade\View;

class Order extends WebBaseController
{
    public function createOrder()
    {
    	
        $param   = $this->request->param();

        $course     = new Course();
        $courseInfo  = $course->getCourseInfo($param['id'],'id,title,cource_image_url,sell_price,cource_tag,description');
        // print_r($courseInfo);exit();
        return view('', [
            'course' => $courseInfo,
        ]);
    }

    //支付
    public function pay()
    {   
        $param   = $this->request->param();
        print_r($param);exit();
    }

}
