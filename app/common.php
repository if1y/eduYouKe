<?php
use app\util\Tools;
// 应用公共文件
function adminMenuBuild($data)
{
	print_r($data);exit();
}

//检测选中状态
function indexActive($data)
{
    $formatTree = Tools::formatTree($data);
    foreach ($formatTree as $key => $value) {
    	if ($value['active']) {
    		return '';
    	}
    }
    return 'active';
}
