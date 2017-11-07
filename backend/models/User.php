<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 15:31
 */

namespace backend\models;


use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public $rePassword;
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'rePassword'=>'确认密码',
            'email'=>'邮箱',
            'status'=>'状态',
        ];
    }
    public function rules()
    {
        return [
            [['username','password','rePassword','email','status'],'required'],
            ['password','compare','compareAttribute'=>'rePassword','operator'=>'=='],
            ['email','email'],
        ];
    }
}
