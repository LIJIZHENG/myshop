<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 15:33
 */

namespace frontend\controllers;


use frontend\models\Member;
use yii\web\Controller;

class MemberController extends Controller
{
    public function actionRegister(){
        $member = new Member();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $member->load($request->post());
            if ($member->validate()){
                $member->password_hash = \Yii::$app->security->generatePasswordHash($member->password_hash);
                $member->save();
                echo "注册成功";die;
            }else{
                echo "注册失败";
            }
        }
        return $this->render('regist');
    }
    public function actionCheckName(){
        $request = \Yii::$app->request;
        $username = $request->post('username');
        $member = Member::findOne(['username'=>$username]);
        if ($member){
            return false;
        }else{
            return true;
        }
    }
}