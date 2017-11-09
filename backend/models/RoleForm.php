<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 10:40
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $permissions;
    public function attributeLabels()
    {
        return [
            'name'=>'角色',
            'description'=>'描述',
            'permissions'=>'权限'
        ];
    }
    public function rules()
    {
        return [
            [['name','description','permissions'],'required'],
        ];
    }
    public static function getPermissions(){
        $permissions = \Yii::$app->authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }
}