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

        $index = $this->render('index',['articleCat'=>$articleCat]);
        file_put_contents('index.html',$index);
        return $index;
    }

}