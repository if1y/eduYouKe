<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;

class Order extends WebBaseController
{
    public function createOrder()
    {
        return View::fetch('');
    }
    
}
