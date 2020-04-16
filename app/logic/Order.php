<?php
namespace app\logic;

class Order
{
    //获取当前商品详情
    public function getCommodityInfo($param)
    {

        switch ($param['type'])
        {
            case 'vip':

                $info = (new Setting())->getSettingInfo(['id' => $param['id']], 'id,title,title as description,content as price');

                break;
            case 'course':

                $info = (new Course())->getCourseInfo(
                    $param['id'],
                    'id,title,cource_image_url as image_url,sell_price as price ,cource_tag,description'
                );
                break;
            default:
                $info = null;
                break;
        }

        if ($info)
        {
            return array_merge($info->toArray(), ['type' => $param['type']]);
        }

    }
}
