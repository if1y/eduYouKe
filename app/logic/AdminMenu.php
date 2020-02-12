<?php
namespace app\logic;
use app\model\AdminMenu as AdminMenuModel;
use app\util\Tools;
use app\util\Menu;


class AdminMenu extends AdminMenuModel
{
	/**
	 * [getMenuList 获取当前目录列表]
	 * @return [type] [description]
	 */
	public function getMenuList()
	{
		$menu = $this->where('delete_status',0)->order('sort', 'desc')->select()->toArray();
        return Tools::formatTree(Tools::listToTree($menu, 'id', 'parent_id'),0,'title');
	}

}