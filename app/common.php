<?php
// 应用公共文件
function getAvatarUrl($avatar)
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
