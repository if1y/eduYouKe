<?php
namespace app\model;
use think\Model;


class AdminMenu extends Model
{

	protected $autoWriteTimestamp = true;
	protected $updateTime         = false;


	/**
	 * 基础查询
	 */
	protected function base($query)
	{
		$query->where('show_status', 1);
	}

	//获取详情
	public function getAdminAdminMenuInfo($id, $fields = '*')
	{
		if (is_array($id))
		{
			return $this->field($fields)->where($id)->find();
		}
		else
		{
			return $this->field($fields)->where('id', $id)->find();
		}

	}

}