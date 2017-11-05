<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 15:09
 */

namespace backend\controllers;


use backend\models\GoodsCategory;
use yii\web\Controller;

class GoodsCategoryController extends Controller
{
    public function actionList(){
        $gCategories = GoodsCategory::find()->all();
        return $this->render('list',['gCategories'=>$gCategories]);
    }
    public function actionAdd(){
        $gCategories = new GoodsCategory();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $gCategories->load($request->post());
            if ($gCategories->validate()){
                //判断是否是根节点
                if ($gCategories->parent_id == 0){
                    $gCategories->makeRoot();
                    \Yii::$app->session->setFlash('添加顶级分类成功');
                }else{
                    $parentNode = GoodsCategory::findOne(['id'=>$gCategories->parent_id]);
                    $gCategories->prependTo($parentNode);
                    \Yii::$app->session->setFlash('添加子分类成功');
                }
                return $this->redirect(['list']);
            }
        }
        return $this->render('add',['gCategories'=>$gCategories]);
    }
}