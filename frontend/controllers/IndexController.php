<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 14:25
 */

namespace frontend\controllers;


use backend\models\GoodsCategory;
use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex(){
        $categories = GoodsCategory::find()->roots()->all();
        return $this->render('index',['categories'=>$categories]);
    }
}