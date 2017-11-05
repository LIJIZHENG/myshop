<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 16:48
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleController extends Controller
{
    public function actionList(){
        //分页
        $pagination = new Pagination();
        $pageSize = 2;
        $condition = Article::find()->where(['<>','status','-1']);
        $total = $condition->count();
        $pagination->pageSize = $pageSize;
        $pagination->totalCount = $total;
        //查询数据
        $articles = $condition->limit($pageSize)->offset($pagination->offset)->all();
        return $this->render('list',['articles'=>$articles,'pagination'=>$pagination]);
    }
    public function actionAdd(){
        $article = new Article();
        $content = new ArticleDetail();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $article->load($request->post());
            $content->load($request->post('content'));
            if ($article->validate() && $content->validate()){
                $article->create_time = time();
                $article->save();
                $content->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/list']);
            }else{
                var_dump($article->getErrors());die;
            }
        }
        return $this->render('add',['article'=>$article,'content'=>$content]);
    }
    public function actionEdit($id){
        $article = Article::findOne($id);
        $content = ArticleDetail::findOne($id);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $article->load($request->post());
            $content->load($request->post('content'));
            if ($article->validate() && $content->validate()){
                $article->save();
                $content->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article/list']);
            }else{
                var_dump($article->getErrors());die;
            }
        }
        return $this->render('add',['article'=>$article,'content'=>$content]);
    }
    public function actionDelete(){
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $article = Article::updateAll(['status'=>-1],['id'=>$id]);
        if ($article){
            return 1;
        }else{
            return -1;
        }
    }
}