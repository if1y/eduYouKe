<?php
use app\util\Html;

// 应用公共文件
function getUrlPath($avatar)
{
    if (!empty($avatar))
    {
        if (!strpos($avatar, "http"))
        {

            return '/storage/' . $avatar;
        }
    }
    return $avatar;
}

function buildConfigHtml($value)
{
	// print_r($value);exit();
	return Html::buildHtml($value);

}