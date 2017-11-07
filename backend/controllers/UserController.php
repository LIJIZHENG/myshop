<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 15:30
 */

namespace backend\controllers;


use backend\models\User;
use yii\data\Pagination;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionList(){
        $query = User::find();
        $pagination = new Pagination();
        $pagination->pageSize = 2;
        $pagination->totalCount = $query->count();
        $users = $query->limit($pagination->limit)->offset($pagination->offset)->all();
        return $this->render('list',['users'=>$users,'pagination'=>$pagination]);
    }
    public function actionAdd(){
        $user = new User();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $user->load($request->post());
            if ($user->validate()){
                $user->password_hash = \Yii::$app->security->generatePasswordHash($user->password);
                $user->auth_key = \Yii::$app->security->generateRandomString();
                $user->create_at = time();
                $user->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }else{
                var_dump($user->getErrors());die;
            }
        }
        return $this->render('add',['user'=>$user]);
    }
    public function actionEdit($id){
        $user = User::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $user->load($request->post());
            if ($user->validate()){
                $user->password_hash = \Yii::$app->security->generatePasswordHash($user->password);
                $user->update_at = time();
                $user->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }else{
                var_dump($user->getErrors());die;
            }
        }
        return $this->render('edit',['user'=>$user]);
    }
    public function actionDelete($id){
        $result = User::updateAll(['status'=>0],['id'=>$id]);
        if ($result){
            return 1;
        }else{
            return 0;
        }
    }
}