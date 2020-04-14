<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2019 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// | Date: 2019/01/11
// | Time:下午 04:32
// +----------------------------------------------------------------------
namespace app\api\service;

use app\api\model\Order;
use think\db\Query;
use app\api\service\AliPay;
use app\api\service\WxPay;
use think\Db;

class OrderService
{
    /**
     * Notes:支付下单
     * User: kongdeci
     * DateTime: 2019/7/26 18:29
     * @param $data
     * @return \app\api\service\AliPay|\app\api\service\WxPay|bool
     */
    public function pay($data)
    {
        if ($data['pay_type'] == 2) {
            $aliPay = new AliPay();
            return $aliPay->index($data);
        } else if ($data['pay_type'] == 1) {
            $wxPay = new WxPay();
            return $wxPay->index($data);
        } else {
            return false;
        }
    }

    /**
     * Notes:支付回调接口（异步通知）
     * User: kongdeci
     * DateTime: 2019/7/26 17:43
     */
    public function payNotifyCallback($type)
    {
        if ($type == 2) {
            $aliPay = new AliPay();
            $res = $aliPay->notify();
        } else if ($type == 1) {
            $wxPay = new WxPay();
            $res = $wxPay->notify();
        } else {
            recordLog('','实际付款订单信息---error---111');
            return false;
        }

        if (!empty($res)) {

            $orderModel = new Order();
            $orderinfo = $orderModel->where(['order_code' => $res['order_code'], 'status' => 1])->field('id,user_id,actual_price,object_id,type,market_time_limited_item_id')->find();

            if ($orderinfo && $orderinfo['actual_price'] == $res['actual_price']) {

                $orderModel->where(['id' => $orderinfo['id']])->update(['pay_type' => $type, 'status' => 2, 'pay_time' => time()]);

                //商品/活动订单
                if ($orderinfo['type'] == 1) {

                    //更新商品销量
                    Db::name('item')->where('id', $orderinfo['object_id'])->setInc('sale_num');

                    //商品通知java
                    $orderModel->cancelOrderToJava($orderinfo['id'], 1);

                    //购买壹会员产品，更新用户身份、获得壹会员徽章
                    $vip_type = Db::name('item')->where(['id'=>$orderinfo['object_id']])->value('vip_type'); //商品信息

                    recordLog('','实际付款订单信息:' . json_encode($orderinfo), '商品字段(vip_type)的值:'. $vip_type);

                    if($vip_type > 1){

                        $orderModel->updateUserLevel($orderinfo['user_id'], $vip_type);
                    }

                    //有限时优惠
                    if (!empty($orderinfo['market_time_limited_item_id'])) {
                        $this->postmarketTimeLimitedItemBuyCount($orderinfo['market_time_limited_item_id']);
                    }
                }
            }else{
                recordLog('','实际付款订单信息---error---333');
            }
        }else{
            recordLog('','实际付款订单信息---error---333');
        }
    }


    /**
     * Notes:检测是否存在限时优惠并计算价格
     * User: yaoyong
     * DateTime: 2019/8/1 14:40
     */
    public function getMarketTimeLimitedPrice($item_id)
    {
        $time = time();

        $marketTime = Db::table('item')
            ->alias('item')
            ->field([
                'item.name',
                'item.type',
                'item.price',
                'item.activity_enroll_start_time',
                'item.activity_enroll_end_time',
                'item.activity_start_time',
                'item.activity_end_time',
                'item.vip_type',
                'item.item_test_paper_id',
                'limited.start_time',
                'limited.stop_time',
                'limited.tag',
                'limiteditem.id',
                'limiteditem.item_id',
                'limiteditem.discount_price',
                'limiteditem.limited_num',
                'limiteditem.buy_count'
            ])
            ->leftJoin('market_time_limited_item limiteditem', 'limiteditem.item_id=item.id')
            ->leftJoin('market_time_limited limited', 'limited.id=limiteditem.market_time_hot_id')
            ->where([
                ["item.is_delete", "=", 1],
                ["item.customer_shelf_status", "=", 2],
                ["limiteditem.delete_status", "=", 0],
                ["limiteditem.type", "=", "1"],
                ["limited.delete_status", "=", "0"],
                ["limited.show_status", "=", "1"],
                ["limited.delete_status", "=", "0"],
                ["limited.start_time", "<", $time],
                ["limited.stop_time", ">", $time],
                ["limiteditem.limited_num", ">", "limiteditem.buy_count"],
                ["limiteditem.item_id", "=", $item_id],
            ])->find();

        $product = [];
        //有限制优惠
        if (!empty($marketTime) && is_array($marketTime)) {
            $product['id'] = $marketTime['id'];//限时优惠商品表Id
            //$product['item_id']=$marketTime['item_id'];//商品Id
            $product['discount_type'] = 1;//0没有优惠，1限时优惠
            $product['discount_price'] = $marketTime['price'] - $marketTime['discount_price'];  //优惠了多少钱
            $product['original_price'] = $marketTime['price'];  //原价
            $product['actual_price'] = $marketTime['discount_price'];   //商品付款价
            $product['type'] = $marketTime['type']; //商品类型
            $product['vip_type'] = $marketTime['vip_type']; //购买后成为的会员类型：1.非会员，2.壹会员
            $product['item_test_paper_id'] = $marketTime['item_test_paper_id']; //测评试卷id

            $product['show_status'] = '';

            if($marketTime['type']==3){
                if ($time < $marketTime['activity_enroll_start_time']) {
                    $product['show_status'] = 1;
                }elseif ($time > $marketTime['activity_enroll_end_time']) {
                    if($time > $marketTime['activity_start_time'] && $time < $marketTime['activity_end_time']){
                        $product['show_status'] = 3;
                    }else{
                        $product['show_status'] = 4;
                    }
                }elseif ($time > $marketTime['activity_enroll_start_time'] && $time < $marketTime['activity_enroll_end_time']) {
                    $product['show_status'] = 2;
                }
            }

            $product['name'] = $marketTime['name'];//商品名称
            $product['tag'] = $marketTime['tag'];//活动标签
            $product['countdown'] = $marketTime['stop_time'] - $time;//活动倒计时
        } else {
            $productinfo = Db::table('item')
            ->field([
                'id AS item_id',
                'name',
                'type',
                'price',
                'marking_price',
                'activity_enroll_start_time',
                'activity_enroll_end_time',
                'activity_start_time',
                'activity_end_time',
                'vip_type',
                'item_test_paper_id'
              ])
            ->where([['is_delete', '=', 1], ['customer_shelf_status', '=', '2'], ["id", "=", $item_id]])
            ->find();

            if(!empty($productinfo) && is_array($productinfo)) {
                $product['id'] = 0; //限时优惠商品表Id
                $product['discount_type'] = 0;//0没有优惠，1限时优惠
                $product['discount_price'] = 0;//优惠了多少钱
                $product['original_price'] = $productinfo['price'];//原价
                $product['actual_price'] = $productinfo['price'];//商品付款价
                $product['type'] = $productinfo['type'];//商品类型

                if($productinfo['type'] == 3){
                    if ($time < $productinfo['activity_enroll_start_time']) {
                        $product['show_status'] = 1;
                    }elseif ($time > $productinfo['activity_enroll_end_time']) {
                        if($time > $productinfo['activity_start_time'] && $time < $productinfo['activity_end_time']){
                            $product['show_status'] = 3;
                        }else{
                            $product['show_status'] = 4;
                        }
                    }elseif ($time > $productinfo['activity_enroll_start_time'] && $time < $productinfo['activity_enroll_end_time']) {
                        $product['show_status'] = 2;
                    }
                }

                $product['name'] = $productinfo['name']; //商品名称
                $product['vip_type'] = $productinfo['vip_type']; //购买后成为的会员类型：1.非会员，2.壹会员
                $product['item_test_paper_id'] = $productinfo['item_test_paper_id']; //测评试卷id
                $product['tag'] = ''; //活动标签
                $product['countdown'] = ''; //活动倒计时
            }
        }

        unset($product['activity_enroll_start_time']);
        unset($product['activity_enroll_end_time']);
        unset($product['activity_start_time']);
        unset($product['activity_end_time']);

        return $product;
    }

    /**
     * Notes:更新限时购和限时抢购买量
     * User: yaoyong
     * DateTime: 2019/8/15 15:14
     */
    public function postmarketTimeLimitedItemBuyCount($market_time_limited_item_id)
    {
        if(empty($market_time_limited_item_id)) return false;

        $res = Db::table('market_time_limited_item')->field('limited_num,buy_count')->where('id', '=', $market_time_limited_item_id)->find();
        if($res['limited_num'] > $res['buy_count']){
            return Db::table('market_time_limited_item')->where('id', '=', $market_time_limited_item_id)->setInc('buy_count');
        }
    }

}