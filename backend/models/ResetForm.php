<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 16:09
 */

namespace backend\models;


use yii\base\Model;

class ResetForm extends Model
{
    public $password;
    public $newPassword;
    public $rePassword;
    public function attributeLabels()
    {
        return [
            'password'=>'原密码',
            'newPassword'=>'新密码',
            'rePassword'=>'确认密码'
        ];
    }
    public function rules()
    {
        return [
            [['password','newPassword','rePassword'],'required'],
            ['newPassword','compare','compareAttribute'=>'rePassword']
        ];
    }
}