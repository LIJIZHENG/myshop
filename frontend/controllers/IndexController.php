<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 14:25
 */

namespace frontend\controllers;


use backend\models\ArticleCategory;
use backend\models\GoodsCategory;
use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex(){
        //查询底部文章分类
        $articleCat = ArticleCategory::find()->where(['status'=>1])->all();
        //查询商品顶级分类
        $categories = GoodsCategory::find()->roots()->all();
        return $this->render('index',['categories'=>$categories,'articleCat'=>$articleCat]);
    }
    public function actionBottom(){

    }
}