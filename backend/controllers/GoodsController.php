<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 22:26
 */

namespace backend\controllers;


use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use yii\web\Controller;

class GoodsController extends Controller
{
    public function actionList(){
        $goods = Goods::find()->all();
        return $this->render('list',['goods'=>$goods]);
    }
    public function actionAdd(){
        $goods = new Goods();
        $goodsGallery = new GoodsGallery();
        $goodsIntro = new GoodsIntro();
        $brand = new Brand();
        $request = \Yii::$app->request;
        if ($request->isPost){

        }
        return $this->render('add',['goods'=>$goods,'goodsGallery'=>$goodsGallery,'goodsIntro'=>$goodsIntro,'brand'=>$brand]);
    }
}