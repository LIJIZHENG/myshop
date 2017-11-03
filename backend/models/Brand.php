<?php
namespace backend\models;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 14:01
 */
class Brand extends ActiveRecord
{
    public $imgFile;
    public function attributeLabels()
    {
        return [
            'name'=>'名称',
            'intro'=>'简介',
            'imgFile'=>'品牌logo',
            'sort'=>'排序',
            'status'=>'状态'
        ];
    }
    public function rules()
    {
        return [
            [['name','intro','sort','status'],'required'],
            ['imgFile','file','extensions'=>['jpg','jpeg','png','gif']],
        ];
    }
}