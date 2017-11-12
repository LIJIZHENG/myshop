<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 15:16
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class Member extends ActiveRecord
{
    public $repassword;
    public $checkcode;
    public function rules()
    {
        return [
            [['username','password','repassword','email','tel','checkcode'],'required'],
            ['password_hash','compare','compareAttribute'=>'repassword'],
            ['email','email'],
            ['checkcode','captcha']
        ];
    }
}