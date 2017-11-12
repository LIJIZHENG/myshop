<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 15:30
 */

namespace backend\controllers;


use backend\filter\RbacFilter;
use backend\models\User;
use yii\data\Pagination;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionList(){
        $query = User::find()->where(['status'=>1]);
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
                $user->created_at = time();
                $user->save();
                $auth = \Yii::$app->authManager;
                foreach ($user->roles as $roleName){
                    $role = $auth->getRole($roleName);
                    $auth->assign($role,$user->getOldAttribute('id'));
                }

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
        $user->password = $user->password_hash;
        $auth = \Yii::$app->authManager;
        $roles = $auth->getAssignments($id);
        $user->roles = array_keys($roles);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $user->load($request->post());
            if ($user->validate()){
                $user->updated_at = time();
                $user->save();
                $auth->revokeAll($id);
                foreach ($user->roles as $roleName){
                    $role = $auth->getRole($roleName);
                    $auth->assign($role,$user->getOldAttribute('id'));
                }
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['list']);
            }else{
                var_dump($user->getErrors());die;
            }
        }
        $user->password = $user->password_hash;
        return $this->render('add',['user'=>$user]);
    }
    public function actionDelete(){
        $requset = \Yii::$app->request;
        $id = $requset->post('id');
        $result = User::updateAll(['status'=>0],['id'=>$id]);
        if ($result){
            return 1;
        }else{
            return 0;
        }
    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ]
        ];
    }
}