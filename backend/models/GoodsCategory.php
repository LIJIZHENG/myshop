<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 15:10
 */

namespace backend\models;


use yii\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class GoodsCategory extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'name'=>'商品分类名',
            'parent_id'=>'上级分类',
            'intro'=>'简介'
        ];
    }
    public function rules()
    {
        return [
            [['name','parent_id',],'required'],
            ['intro','safe']
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new GoodsCategoryQuery(get_called_class());
    }
    //获取zTree需要的json数据
    public static function getNodes(){
        $nodes = self::find()->select(['id','name','parent_id'])->all();
        $nodes = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],$nodes);
        return Json::encode($nodes);
    }
    //获取上级分类名称
    public static function getParentName($parent_id){
        $parent = self::findOne(['id'=>$parent_id]);
        return empty($parent['name'])?'顶级分类':$parent['name'];
    }
}