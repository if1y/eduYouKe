<?php
namespace app\web\controller;
use app\WebBaseController;
use think\facade\View;

class Article extends WebBaseController
{
    public function detail()
    {
        return View::fetch();
    }
    
}
