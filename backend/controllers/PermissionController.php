<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 10:37
 */

namespace backend\controllers;


use backend\filter\RbacFilter;
use backend\models\PermissionForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PermissionController extends Controller
{
    public function actionList(){
        $permissions = \Yii::$app->authManager->getPermissions();
        return $this->render('list',['permissions'=>$permissions]);
    }
    public function actionAdd(){
        $permission = new PermissionForm();
        $permission->scenario = PermissionForm::SCENARIO_ADD;
        $request = \Yii::$app->request;
        if ($request->isPost){
            $permission->load($request->post());
            if ($permission->validate()){
                $auth = \Yii::$app->authManager;
//                if ($auth->getPermission($permission->name) === null){
                    $perm = $auth->createPermission($permission->name);
                    $perm->description = $permission->description;
                    $auth->add($perm);
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['list']);
//                }else{
//                    $permission->addError('name','权限已存在');
//                }

            }else{
                var_dump($permission->getErrors());die;
            }
        }
        return $this->render('add',['permission'=>$permission]);
    }
    public function actionEdit($name){
        $auth = \Yii::$app->authManager;
        $perm = $auth->getPermission($name);
        if ($perm === null){
            throw new NotFoundHttpException('该权限不存在');
        }
        $permission = new PermissionForm();
        $permission->scenario = PermissionForm::SCENARIO_EDIT;
        $permission->oldName = $perm->name;
        $permission->name = $perm->name;
        $permission->description = $perm->description;
        $request = \Yii::$app->request;
        if ($request->isPost){
            $permission->load($request->post());
            if ($permission->validate()){
                if ($auth->getPermission($permission->name) === null | $name == $permission->name){
                    $perm->name = $permission->name;
                    $perm->description = $permission->description;
                    $auth->update($name,$perm);
                }else{
                    \Yii::$app->session->setFlash('danger','权限名已存在');
                    return $this->redirect(['edit','name'=>$name]);
                }

                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['list']);
            }else{
                var_dump($permission->getErrors());die;
            }
        }
        return $this->render('add',['permission'=>$permission]);
    }
    public function actionDelete(){
        $name = \Yii::$app->request->post('name');
        $auth = \Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        $result = $auth->remove($permission);
        return $result?1:0;
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