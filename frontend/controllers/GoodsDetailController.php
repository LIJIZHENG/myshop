<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 16:10
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use yii\web\Controller;

class GoodsDetailController extends Controller
{
    public function actionDetail($id){
        $goods = Goods::findOne(['id'=>$id]);
        $goodsIntro = GoodsIntro::findOne(['goods_id'=>$id]);
        $goodsGallery = GoodsGallery::find()->where(['goods_id'=>$id])->all();
        return $this->render('detail',['goods'=>$goods,'goodsIntro'=>$goodsIntro,'goodsGallery'=>$goodsGallery]);
    }
}