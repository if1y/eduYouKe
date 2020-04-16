<?php

namespace app\service;

class Pay
{
	//支付
	public function pay($param)
	{	

		switch ($param['payType']) {
			case 1:
				return (new AliPay())->pay($param);
				break;
			default:
				(new WxPay())->pay($param);
				break;
		}
	}
}