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
        return $this->render('list',['goodsGalleries'=>$goodsGalleries,'goods_id'=>$id]);
    }
    public function actionAdd(){
        $goodsGallery = new GoodsGallery();
        $request = \Yii::$app->request;
        $goods_id = $request->post('goods_id');
        $path = $request->post('path');
        $goodsGallery->path = $path;
        $goodsGallery->goods_id = $goods_id;
        $goodsGallery->save();
        return $goodsGallery->getOldAttribute('id');
    }
    public function actionDelete(){
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $goodsGallery = GoodsGallery::findOne(['id'=>$id]);
        $result = $goodsGallery->delete();
        if ($result){
            return 1;
        }else{
            return 0;
        }
    }
}