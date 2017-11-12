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
    public $rememberMe;
    public function rules()
    {
        return [
            [['username','password'],'required'],
            ['checkcode','captcha']
        ];
    }
    public function check(){
        $member = Member::findOne(['username'=>$this->username]);
        if ($member){
            if (\Yii::$app->security->validatePassword($this->password,$member->password_hash)){
                $member->last_login_time = time();
                $member->last_login_ip = ip2long(\Yii::$app->request->userIP);
                $member->save(0);
                \Yii::$app->user->login($member,$this->rememberMe?7*24*3600:0);
                return true;
            }else{
                return false;
            }
        }
        return false;
    }
}