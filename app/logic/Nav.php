<?php
namespace app\logic;

use app\model\Nav as NavModel;

class Nav extends NavModel
{
	public function test($value='')
	{
		echo "string";exit();
	}
}