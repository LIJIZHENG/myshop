<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 17:52
 */

namespace backend\models;


use yii\db\ActiveRecord;

class ArticleDetail extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'content'=>'内容'
        ];
    }
    public function rules()
    {
        return [
            ['content','required']
        ];
    }
}