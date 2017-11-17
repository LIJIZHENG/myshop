<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17
 * Time: 10:46
 */

namespace frontend\models;


use backend\models\Goods;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Order extends ActiveRecord
{
    public static function getCart()
    {
        $member_id = \Yii::$app->user->id;
        $goods = Cart::find()->where(['member_id' => $member_id])->asArray()->all();
        $goods = ArrayHelper::map($goods, 'goods_id', 'amount');

        $html = '';
        $total = 0;
        $count = 0;
        if ($goods) {
            foreach ($goods as $key => $v) {
                $goods_id = $key;
                $item = Goods::findOne(['id' => $goods_id]);
                $html .= '<tr data-id="' . $goods_id . '">
            <td class="col1"><a href="' . Url::to(['goods-detail/detail', 'id' => $goods_id]) . '"><img src="http://oywgoal5u.bkt.clouddn.com/' . $item->logo . '" alt="" />
            </a>  <strong><a href="' . Url::to(['goods-detail/detail', 'id' => $goods_id]) . '">' . $item->name . '</a></strong></td>
            <td class="col3">￥<span>' . $item->shop_price . '</span></td>
            <td class="col4">' . $v . '</td>
            <td class="col5">￥<span>' . number_format(($item->shop_price) * $v, '2', '.', '') . '</span></td>';
            $total += ($item->shop_price)*$v;
            $count += $v;
            }
            return ['html'=>$html,'total'=>$total,'count'=>$count];
        }
    }
    public static function getLogo($order_id){
        $pic = '';
        $orderGoods = OrderGoods::find()->where(['order_id'=>$order_id])->all();
        foreach ($orderGoods as $key=>$goods){
            if ($key<=2){
                $pic .='<img src="http://oywgoal5u.bkt.clouddn.com/'.$goods->logo.'" alt="" /></a>';
            }
        }
        return $pic;
    }
}