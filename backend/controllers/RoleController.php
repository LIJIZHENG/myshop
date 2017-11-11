<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 10:37
 */

namespace backend\controllers;


use backend\models\RoleForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RoleController extends CommonController
{
    public function actionList(){
        $roles = \Yii::$app->authManager->getRoles();
        return $this->render('list',['roles'=>$roles]);
    }
    public function actionAdd(){
        $role = new RoleForm();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $role->load($request->post());
            if ($role->validate()){
                $auth = \Yii::$app->authManager;
                if ($auth->getRole($role->name) === null){
                    $rl = $auth->createRole($role->name);
                    $rl->description = $role->description;
                    $auth->add($rl);
                    foreach ($role->permissions as $permissionName){
                        $permission = $auth->getPermission($permissionName);
                        $auth->addChild($rl,$permission);
                    }
                }else{
                    \Yii::$app->session->setFlash('danger','角色名已存在');
                    $this->redirect(['add']);
                }
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }else{
                var_dump($role->getErrors());die;
            }
        }
        return $this->render('add',['role'=>$role]);
    }
    public function actionEdit($name){
        $auth = \Yii::$app->authManager;
        $rl = $auth->getRole($name);
        $role = new RoleForm();
        $role->name = $rl->name;
        $role->description = $rl->description;
        $role->permissions = array_keys($auth->getPermissionsByRole($name));
        $request = \Yii::$app->request;
        if ($request->isPost){
            $role->load($request->post());
            if ($role->validate()){
                if ($auth->getRole($role->name) === null | $name == $role->name){
                    $rl->name = $role->name;
                    $rl->description = $role->description;
                    $auth->update($name,$rl);
                    $auth->removeChildren($rl);
                    foreach ($role->permissions as $permissionName){
                        $permission = $auth->getPermission($permissionName);
                        $auth->addChild($rl,$permission);
                    }
                }else{
                    \Yii::$app->session->setFlash('danger','角色名已存在');
                    return $this->redirect(['edit','name'=>$name]);
                }
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['list']);
            }else{
                var_dump($role->getErrors());die;
            }
        }
        return $this->render('add',['role'=>$role]);
    }
    public function actionDelete(){
        $name = \Yii::$app->request->post('name');
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole($name);
        $result = $auth->remove($role);
        return $result?1:0;
    }
}