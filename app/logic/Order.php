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

            case 'order':
                $orderInfo = $this->getOrderInfo($param['id']);
                $info      = $this->getCommodityInfo([
                    'id' => $orderInfo['commodity_id'],
                    'type' => $orderInfo['order_type'] == 1 ? 'course' : 'vip',
                ]);
                break;

            default:
                $info = null;
                break;
        }

        if ($info)
        {
            return array_merge(is_object($info) ? $info->toArray() : $info, ['type' => $param['type']]);
        }

    }

    //创建订单
    public function createOrder($param)
    {
        //获取订单号
        $snowflake = new \Godruoyi\Snowflake\Snowflake;
        $orderId   = $snowflake->id();

        $info = $this->getCommodityInfo($param);

        switch ($param['type']) {
            case 'order':
                    $this->where('id',$param['id'])->save(['order_no'=>$orderId]);
                break;
            default:
                $this->save([
                    'order_no' => $orderId,
                    'user_id' => getUserInfoData(),
                    'commodity_id' => $param['id'],
                    'amount_total' => $info['price'],
                    'order_type' => $info['type'] == 'course' ? 1 : 2,
                    'create_time' => time(),
                ]);
                break;
        }
        return $orderId;
    }

    //获取用户订单列表
    public function getUserOrderList()
    {
        $list = $this->where([
            'delete_status' => 0,
            'show_status' => 1,
            'user_id' => getUserInfoData(),
        ])->paginate(['query' => ['user_id' => getUserInfoData()], 'list_rows' => 10])->each(function ($item)
        {

            $info = $this->getCommodityInfo([
                'id' => $item['commodity_id'],
                'type' => $item['order_type'] == 1 ? 'course' : 'vip',
            ]);
            $item['title']       = $info['title'];
            $item['description'] = $info['description'];
            $item['price']       = $info['price'];
            $item['image_url']   = isset($info['image_url']) ? $info['image_url'] : '';
            return $item;
        });

        return $list;
    }

    //获取后台订单列表
    public function getOrderList($where = [], $field = '*')
    {

        $list = $this->field($field)->where($where)->where([
            'delete_status' => 0,
            'show_status' => 1,
        ])->paginate()->each(function ($item)
        {

            $info = $this->getCommodityInfo([
                'id' => $item['commodity_id'],
                'type' => $item['order_type'] == 1 ? 'course' : 'vip',
            ]);
            $item['title']       = $info['title'];
            $item['description'] = $info['description'];
            $item['price']       = $info['price'];
            $item['image_url']   = isset($info['image_url']) ? $info['image_url'] : '';
            $user = (new User())->getUserInfo($item['user_id'],'nickname');
            $item['nickname']   = $user['nickname'];
            
            return $item;
        });

        return $list;
    }

}
