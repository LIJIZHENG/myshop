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
use yii\web\Cookie;

class CartController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
        if (\Yii::$app->user->isGuest){
            $member_id = \Yii::$app->user->id;
            //判断cookie中是否有cart
            $cartCookie =Cart::getCart();
            if ($cartCookie){
                $cartCookie = unserialize($cartCookie);
                foreach ($cartCookie as $key=>$v){
                    Cart::saveData($key,$member_id,$v);
                }
                //删除cookie
                $cookie = \Yii::$app->response->cookies;
                $cookie->remove('cart');
            }
        }

        return $this->render('cart');
    }
    public function actionAdd(){
        $request = \Yii::$app->request;
        $goods_id = $request->post('goods_id');
        $amount = $request->post('amount');
        if(\Yii::$app->user->isGuest){
            //没有登录的情况下,保存到cookie中
            $cart = Cart::getCart();
            //判断cartcookie是否存在
            if ($cart){
                //判断cart中是否有该商品记录
                $cart = unserialize($cart);
                if (isset($cart[$goods_id])){
                    $cart[$goods_id] += $amount;
                    Cart::saveCart($cart);
                }else{
                    $cart[$goods_id] = $amount;
                    Cart::saveCart($cart);
                }

                return $this->redirect(['index']);
            }else{
                $cart = [$goods_id=>$amount];
                Cart::saveCart($cart);
                return $this->redirect(['index']);
            }
        }else{
            //已登录
            $member_id = \Yii::$app->user->id;
            $result = Cart::saveData($goods_id,$member_id,$amount,$request);
            if ($result){
                return $this->redirect(['index']);
            }
        }

    }
    public function actionChangeNum(){
        $request = \Yii::$app->request;
        $goods_id = $request->post('goods_id');
        $amount = $request->post('amount');
        if (\Yii::$app->user->isGuest){
            $cart = unserialize(Cart::getCart());
            $cart[$goods_id] =$amount;
            Cart::saveCart($cart);
        }else{
            $member_id = \Yii::$app->user->id;
            $cart = Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
            $cart->amount = $amount;
            $cart->save();
        }

    }
    public function actionDelete(){
        $goods_id = \Yii::$app->request->post('goods_id');
        if (\Yii::$app->user->isGuest){
            $cart = unserialize(Cart::getCart());
            unset($cart[$goods_id]);
            Cart::saveCart($cart);
            return 1;
        }else{

            $member_id = \Yii::$app->user->id;
            $result = Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id])->delete();
            if ($result){
                return 1;
            }else{
                return 0;
            }
        }
    }
}