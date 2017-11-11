<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 16:10
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleCategoryController extends CommonController
{
    public function actionList(){
        //分页
        $pagination = new Pagination();
        $pageSize = 2;
        $condition = ArticleCategory::find()->where(['<>','status','-1']);
        $total = $condition->count();
        $pagination->pageSize = $pageSize;
        $pagination->totalCount = $total;
        //查询数据
        $aCategories = $condition->limit($pageSize)->offset($pagination->offset)->all();
        return $this->render('list',['aCategories'=>$aCategories,'pagination'=>$pagination]);
    }
    public function actionAdd(){
        $aCategory = new ArticleCategory();
        $request = \Yii::$app->request;
        if ($request->isPost){
         $aCategory->load($request->post());
         if ($aCategory->validate()){
             $aCategory->save();
             \Yii::$app->session->setFlash('success','添加成功');
             return $this->redirect(['article-category/list']);
         }else{
             var_dump($aCategory->getErrors());die;
         }
        }
        return $this->render('add',['aCategory'=>$aCategory]);
    }
    public function actionEdit($id){
        $aCategory = ArticleCategory::findOne($id);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $aCategory->load($request->post());
            if ($aCategory->validate()){
                $aCategory->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article-category/list']);
            }else{
                var_dump($aCategory->getErrors());die;
            }
        }
        return $this->render('add',['aCategory'=>$aCategory]);
    }
    public function actionDelete(){
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $aCategory = ArticleCategory::findOne(['id'=>$id]);
        $articles = $aCategory->articles;
        if ($articles == []){
            $result = ArticleCategory::updateAll(['status'=>-1],['id'=>$id]);
            if ($result){
                return 1;
            }else{
                return -1;
            }
        }else{
            return 0;
        }
    }
}