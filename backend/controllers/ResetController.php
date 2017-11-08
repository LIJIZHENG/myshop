<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 16:08
 */

namespace backend\controllers;


use backend\models\ResetForm;
use backend\models\User;
use yii\web\Controller;

class ResetController extends Controller
{
    public function actionReset(){
        $id = \Yii::$app->user->id;
        $reset = new ResetForm();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $reset->load($request->post());
            if ($reset->validate()){
                $user = User::findOne(['id'=>$id]);
                if (\Yii::$app->security->validatePassword($reset->password,$user->password_hash)){
                    $user->password_hash = \Yii::$app->security->generatePasswordHash($reset->newPassword);
                    $user->updated_at = time();
                    $user->save(0);
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['login/logout']);
                }else{
                    \Yii::$app->session->setFlash('danger','原密码错误');
                }
            }else{
                var_dump($reset->getErrors());die;
            }
        }
        return $this->render('reset',['reset'=>$reset]);
    }
}