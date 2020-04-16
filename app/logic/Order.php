<?php
namespace app\logic;
use app\model\Order as OrderModel;

class Order extends OrderModel
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

    //创建订单
    public function createOrder($param)
    {
        //获取订单号
        $snowflake = new \Godruoyi\Snowflake\Snowflake;
        $orderId = $snowflake->id();

        $info = $this->getCommodityInfo($param);

        $this->save([
            'order_no'=>$orderId,
            'user_id'=>getUserInfoData(),
            'amount_total'=>$info['price'],
            'order_type'=>$info['type'] == 'course' ? 1:2,
            'create_time'=>time(),
        ]);

        return $orderId;

    }

}
