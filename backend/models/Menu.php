<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10
 * Time: 11:18
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Menu extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'name'=>'菜单名称',
            'parent_id'=>'上级菜单',
            'route'=>'地址/路由',
            'sort'=>'排序'
        ];
    }
    public function rules()
    {
        return [
            [['name','parent_id','sort'],'required'],
            ['route','safe']
        ];
    }
    public static function getPermissions(){
        $permissions = \Yii::$app->authManager->getPermissions();
        return [''=>'请选择']+ArrayHelper::map($permissions,'name','name');
    }
    public static function getParent(){
        $prarents = self::find()->select(['id','name'])->where(['depth'=>0])->distinct()->all();
        return ['0'=>'顶级菜单']+ArrayHelper::map($prarents,'id','name');
    }
    public function getChildren(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }

}