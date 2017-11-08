<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 15:31
 */

namespace backend\models;


use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $password;
    public $captcha;
    public $rememberMe;
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'captcha'=>'验证码',
            'rememberMe'=>'记住我'
        ];
    }
    public function rules()
    {
        return [
            [['username','password','captcha'],'required'],
            ['captcha','captcha', 'captchaAction'=>'login/captcha'],
            ['rememberMe','safe']
        ];
    }
    public function check($remember){
        $user = User::findOne(['username'=>$this->username]);
        if ($user){
            $result = \Yii::$app->security->validatePassword($this->password,$user->password_hash);
            if ($result){
                $user->last_login_ip = ip2long(\Yii::$app->request->getUserIP());
                $user->last_login_time = time();
                $user->save(0);
                if ($remember){
                    \Yii::$app->user->login($user,7*24*3600);
                }else{
                    \Yii::$app->user->login($user);

                }


                return true;
            }else{
                $this->addError('password','密码输入错误');
            }
        }else{
            $this->addError('username','用户名输入错误');
        }
    }
}