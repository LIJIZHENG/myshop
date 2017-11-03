<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 16:11
 */

namespace backend\models;


use yii\db\ActiveRecord;

class ArticleCategory extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'name'=>'文章分类',
            'intro'=>'简介',
            'sort'=>'排序',
            'status'=>'状态'
        ];
    }
    public function rules()
    {
        return [
            [['name','sort','status'],'required'],
            ['intro','safe']
        ];
    }
}