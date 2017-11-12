<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 11:52
 */

namespace frontend\controllers;


use frontend\models\LoginForm;
use yii\web\Controller;

class LoginController extends Controller
{
    public function actionLogin(){
        $loginForm = new LoginForm();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $loginForm->load($request->post());
            if ($loginForm->validate() && $loginForm->check()){
                echo '登录成功';die;
            }else{
                echo '登录失败';die;
            }
        }
        return $this->render('login');
    }
}