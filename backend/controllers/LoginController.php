<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 10:26
 */

namespace backend\controllers;



use backend\filter\RbacFilter;
use backend\models\UserForm;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\web\Controller;

class LoginController extends Controller
{
    public function actionLogin(){
//        if  (!\Yii::$app->user->getIsGuest()){
//            return $this->redirect(['user/list']);
//        }
        $userForm = new UserForm();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $userForm->load($request->post());
            if ($userForm->validate()){
                $remember = $userForm->rememberMe;
                if ($userForm->check($remember)){
                    return $this->redirect(['user/list']);
                }else{
                    \Yii::$app->session->setFlash('warning','用户名或账号错误');
                    return $this->redirect(['login/login']);
                }
            }
        }
        return $this->render('login',['userForm'=>$userForm]);
    }
    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(['login/login']);
    }
    public function actions()
    {
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'width'=>200,
                'minLength'=>3,
                'maxLength'=>3
            ]
        ];
    }
}