<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 22:27
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Goods extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'name'=>'商品名称',
            'sn'=>'货号',
            'logo'=>'LOGO图片',
            'goods_category_id'=>'商品分类',
            'brand_id'=>'品牌分类',
            'market_price'=>'市场价格',
            'shop_price'=>'商品价格',
            'stock'=>'库存',
            'sort'=>'排序',
            'is_on_sale'=>'是否在售',
        ];
    }
    public function rules()
    {
        return [
            [['name','sn','logo','goods_category_id','brand_id','market_price','shop_price','stock','is_on_sale','sort'],'required']
        ];
    }
}