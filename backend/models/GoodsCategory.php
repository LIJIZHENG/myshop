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
}