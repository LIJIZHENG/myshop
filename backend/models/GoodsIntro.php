<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 22:32
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsIntro extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'content'=>'商品描述',
        ];
    }
    public function rules()
    {
        return [
            ['content','required'],
        ];
    }
}