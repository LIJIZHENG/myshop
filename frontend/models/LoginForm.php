<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 15:10
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $checkcode;
    public function rules()
    {
        return [
            [['username','password'],'required'],
            ['checkcode','captcha']
        ];
    }
    public function check(){
        $result = Member::findOne(['username'=>$this->username]);
        if ($result){
            if (\Yii::$app->security->validatePassword($this->password,$result->password_hash)){
                return true;
            }else{
                return false;
            }
        }else {
            return false;
        }
    }
}