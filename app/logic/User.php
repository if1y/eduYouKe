<?php
namespace app\logic;
use think\facade\Session;
use app\util\Tools;

class User
{
	public function doLogin($param)
	{	
		$result = 0;
		$userInfo = (new AdminUser())->getAdminUserInfo(['nickname'=>$param['username']]);
		if ($userInfo) {
			$userInfo = $userInfo->toArray();
			Session::set('adminUserInfo',json_encode($userInfo));
			if ($userInfo['password'] == Tools::userMd5($param['password'])) {
				$result = 1;
			}

		}
		return $result;
	}


}
