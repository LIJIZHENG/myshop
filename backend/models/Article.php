<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 16:49
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'name'=>'文章标题',
            'intro'=>'简介',
            'article_category_id'=>'文章分类',
            'sort'=>'排序',
            'status'=>'状态',
        ];
    }
    public function rules()
    {
        return [
            [['name','article_category_id','sort','status'],'required'],
            ['intro','safe']
        ];
    }
}