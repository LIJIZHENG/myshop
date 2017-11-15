<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 16:58
 */

namespace frontend\controllers;


use frontend\models\Cart;
use yii\web\Controller;

class CartController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
        return $this->render('cart');
    }
    public function actionAdd(){
        $cart = new Cart();
        $request = \Yii::$app->request;
        //判断是否已加入购物车
        $goods_id = $request->post('goods_id');
        $member_id = \Yii::$app->user->id;
        $goods = Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$goods_id])->one();
        if ($goods){
            $goods->amount += $request->post('amount');
            if ($goods->validate()){
                $goods->save();
                return $this->redirect(['index']);
            }else{
                var_dump($goods->getErrors());die;
            }
        }else{
            $cart->load($request->post(),'');
            $cart->member_id = $member_id;
            if ($cart->validate()){
                $cart->save();
                return $this->redirect(['index']);
            }else{
                var_dump($cart->getErrors());die;
            }
        }

    }
    public function actionDelete(){
        $id = \Yii::$app->request->post('id');
        $result = Cart::findOne(['id'=>$id])->delete();
        if ($result){
            return 1;
        }else{
            return 0;
        }
    }
}