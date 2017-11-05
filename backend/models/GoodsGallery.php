<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 22:34
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsGallery extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'goods_id'=>'商品ID',
            'path'=>'图片'
        ];
    }
    public function rules()
    {
        return [
            [['goods_id','path'],'required']
        ];
    }
}