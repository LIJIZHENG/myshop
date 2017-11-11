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
    public $oldName;
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
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
            ['name','addName','on'=>[self::SCENARIO_ADD]],
            ['name','editName','on'=>[self::SCENARIO_EDIT]],
        ];
    }
    public function addName(){
        //自定义验证,只验证失败情况
        $auth = \Yii::$app->authManager;
        $permission = $auth->getPermission($this->name);
        if ($permission){
            $this->addError('name','权限已存在');
        }
    }
    public function editName(){
        $auth = \Yii::$app->authManager;
        if ($this->oldName != $this->name){
            $permission = $auth->getPermission($this->name);
            if ($permission){
                $this->addError('name','权限已存在');
            }
        }
    }
}