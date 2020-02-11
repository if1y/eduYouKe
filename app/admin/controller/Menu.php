<?php
namespace app\admin\controller;

use app\AdminBaseController;
use app\logic\AdminMenu;
use think\facade\View;

class Menu extends AdminBaseController
{

    /**
     * [menulist 目录列表]
     * @return [type] [description]
     */
    public function menulist()
    {
        
        $menu = new AdminMenu();
        View::assign('menulist', $menu->getMenuList());
        return View::fetch();
    }

}
