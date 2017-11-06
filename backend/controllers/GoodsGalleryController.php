<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 16:51
 */

namespace backend\controllers;


use backend\models\GoodsGallery;
use yii\web\Controller;

class GoodsGalleryController extends Controller
{
    public function actionList($id){
        $goodsGalleries = GoodsGallery::find()->where(['goods_id'=>$id])->all();
        return $this->render('gallery',['goodsGalleries'=>$goodsGalleries]);
    }
    public function actionAdd(){
        $goodsGallery = new GoodsGallery();
        $request = \Yii::$app->request;
        if ($request->isPost){

        }
        return $this->render('add',['goodsGallery'=>$goodsGallery]);
    }
}