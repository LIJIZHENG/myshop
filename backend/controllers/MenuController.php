<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10
 * Time: 11:17
 */

namespace backend\controllers;


use backend\models\Menu;
use yii\web\Controller;

class MenuController extends Controller
{
    public function actionList(){
        $menus = Menu::find()->all();
        return $this->render('list',['menus'=>$menus]);
    }
    public function actionAdd(){
        $menu = new Menu();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $menu->load($request->post());
            if ($menu->validate()){
                if ($menu->parent_id == 0){
                    $menu->depth = 0;
                }else{
                    $menu->depth = 1;
                }
                $menu->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }
        }
        return $this->render('add',['menu'=>$menu]);
    }
    public function actionEdit($id){
        $menu = Menu::findOne($id);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $menu->load($request->post());
            if ($menu->validate()){
                if ($menu->parent_id == 0){
                    $menu->depth = 0;
                }else{
                    $menu->depth = 1;
                }
                $menu->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['list']);
            }
        }
        return $this->render('add',['menu'=>$menu]);
    }
    public function actionDelete(){
        $id = \Yii::$app->request->post('id');
        $count = Menu::find()->where(['parent_id'=>$id])->count();
        if ($count){
            return -1;
        }
        $result = Menu::findOne($id)->delete();
        if ($result){
            return 1;
        }else{
            return 0;
        }
    }

}