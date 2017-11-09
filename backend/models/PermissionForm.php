<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 10:40
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;
    public $description;
    public function attributeLabels()
    {
        return [
            'name'=>'名称(路由)',
            'description'=>'描述',
        ];
    }
    public function rules()
    {
        return [
            [['name','description',],'required'],
//            ['name','unique']
        ];
    }
}