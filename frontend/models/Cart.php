<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 19:01
 */

namespace frontend\models;


use backend\models\Goods;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Cookie;

class Cart extends ActiveRecord
{
    public function rules()
    {
        return [
        [['goods_id','amount','member_id'],'required']
        ];
    }
    public static function getAllGoods(){
        //查询购物车所有商品
        if(\Yii::$app->user->isGuest){
            $goods = unserialize(Cart::getCart());
        }else{
            $member_id = \Yii::$app->user->id;
            $goods = self::find()->where(['member_id'=>$member_id])->asArray()->all();
            $goods = ArrayHelper::map($goods,'goods_id','amount');
        }
        $html = '';
        if ($goods){
            foreach ($goods as $key=>$v){
                $goods_id = $key;
                $item = Goods::findOne(['id'=>$goods_id]);
                $html .= '<tr data-id="'.$goods_id.'">
            <td class="col1"><a href="'.Url::to(['goods-detail/detail','id'=>$goods_id]).'"><img src="http://oywgoal5u.bkt.clouddn.com/'.$item->logo.'" alt="" />
            </a>  <strong><a href="'.Url::to(['goods-detail/detail','id'=>$goods_id]).'">'.$item->name.'</a></strong></td>
            <td class="col3">￥<span>'.$item->shop_price.'</span></td>
            <td class="col4">
                <a href="javascript:;" class="reduce_num"></a>
                <input type="text" name="amount" value="'.$v.'" class="amount" />
                <a href="javascript:;" class="add_num"></a>
            </td>
            <td class="col5">￥<span>'.number_format(($item->shop_price)*$v,'2','.','').'</span></td>
            <td class="col6"><a href="javascript:;" class="del" >删除</a></td>
        </tr>';
            }
        }
        return $html;
    }
    //获取cookie中的cart
    public static function getCart(){
        $rcookie = \Yii::$app->request->cookies;
        return $rcookie->get('cart');
    }
    //保存cart到cookie
    public static function saveCart($cart){
        $cookie = \Yii::$app->response->cookies;
        $cookies = new Cookie();
        $cookies->name = 'cart';
        $cookies->value = serialize($cart);
        $cookie->add($cookies);
    }
    //已登录,保存cart到数据库
    public static function saveData($goods_id,$member_id,$amount){

        $goods = self::findOne(['member_id'=>$member_id,'goods_id'=>$goods_id]);
        if ($goods){
            $goods->amount += $amount;
            if ($goods->validate()){
                $goods->save();
                return 1;
            }else{
                return 0;
            }
        }else{
            $cart = new Cart();
            $cart->goods_id = $goods_id;
            $cart->member_id = $member_id;
            $cart->amount = $amount;
            if ($cart->validate()){
                $cart->save();
                return 1;
            }else{
                return 0;
            }
        }
    }
}