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
use yii\helpers\Url;

class Cart extends ActiveRecord
{
    public function rules()
    {
        return [
        [['goods_id','amount','member_id'],'required']
        ];
    }
    public static function getAllGoods(){
        $html = '';
        //查询购物车所有商品
        $member_id = \Yii::$app->user->id;
        $goods = self::find()->where(['member_id'=>$member_id])->all();
        if ($goods){
            foreach ($goods as $v){
                $goods_id = $v->goods_id;
                $item = Goods::findOne(['id'=>$goods_id]);
                $html .= '<tr>
            <td class="col1"><a href="'.Url::to(['goods-detail/detail','id'=>$goods_id]).'"><img src="http://oywgoal5u.bkt.clouddn.com/'.$item->logo.'" alt="" />
            </a>  <strong><a href="'.Url::to(['goods-detail/detail','id'=>$goods_id]).'">'.$item->name.'</a></strong></td>
            <td class="col3">￥<span>'.$item->shop_price.'</span></td>
            <td class="col4">
                <a href="javascript:;" class="reduce_num"></a>
                <input type="text" name="amount" value="'.$v->amount.'" class="amount"/>
                <a href="javascript:;" class="add_num"></a>
            </td>
            <td class="col5">￥<span>'.($item->shop_price)*$v->amount.'</span></td>
            <td class="col6"><a href="javascript:;" class="del" data-id="'.$v->id.'">删除</a></td>
        </tr>';
            }
        }

        return $html;
    }
}