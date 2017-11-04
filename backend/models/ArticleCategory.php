<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 16:11
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
    //处理下拉列表所需数据
    public static function getCategories(){

        return ArrayHelper::map(self::find()->where(['<>','status',-1])->all(),'id','name');
    }
    //和文章的关系是一对多
    public function getArticles(){
        return $this->hasMany(Article::className(),['article_category_id'=>'id']);
    }
}