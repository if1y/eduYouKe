<?php
namespace app\logic;
use app\model\AdminUser as AdminUserModel;
use app\util\Tools;
use app\util\Menu;


class AdminUser extends AdminUserModel
{
	// /**
	//  * [getMenuList 获取当前目录列表]
	//  * @return [type] [description]
	//  */
	// public function getAdminUserList()
	// {
	// 	$menu = $this->where('delete_status',0)->order('sort', 'desc')->select()->toArray();
 //        return Tools::formatTree(Tools::listToTree($menu, 'id', 'parent_id'),0,'title');
	// }

}