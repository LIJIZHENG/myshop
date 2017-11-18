<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 19:23
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\OrderGoods;
use frontend\models\Order;
use yii\db\Exception;
use yii\web\Controller;

class OrderController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionOrder(){
        return $this->render('success');
    }
    public function actionList(){
        $member_id = \Yii::$app->user->id;
        $orders = Order::find()->where(['member_id'=>$member_id])->all();
        return $this->render('list',['orders'=>$orders]);
    }
    public function actionAdd(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['login/login']);
        }
        $request = \Yii::$app->request;
        if ($request->isPost){
            $address_id = $request->post('address_id');
            $delivery_name = $request->post('delivery_name');
            $delivery_price = $request->post('delivery_price');
            $payment_name = $request->post('payment_name');
            $order = new Order();
            $member_id = \Yii::$app->user->id;
            $order->member_id = $member_id;
            $address = Address::findOne(['id'=>$address_id]);
            $order->name = $address->name;
            $order->province = $address->province;
            $order->city = $address->city;
            $order->area = $address->area;
            $order->tel = $address->tel;
            $order->address = $address->detail;
            $order->delivery_id = 0;
            $order->delivery_name = $delivery_name;
            $order->delivery_price = $delivery_price;
            $order->payment_id = 0;
            $order->payment_name = $payment_name;
            $order->status =1;
            $order->create_time = time();
            $cart = Order::getCart();
            $order->total = ($cart['total']+$delivery_price);
            $order->trade_no = uniqid();
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                $order->save(0);
                //保存到order_goods表
                $order_id = $order->getOldAttribute('id');

                $cart = Cart::find()->where(['member_id'=>$member_id])->all();
                foreach ($cart as $v){

                    $goods_id = $v->goods_id;
                    $amount = $v->amount;
                    $goods = Goods::findOne(['id'=>$goods_id]);
                    //判断库存是否足够
                    if ($goods->stock < $amount){
                        throw new Exception($goods->name.'库存不足');
                    }
                    $orderGoods = new OrderGoods();
                    $orderGoods->goods_id = $goods_id;
                    $orderGoods->order_id = $order_id;
                    $orderGoods->goods_name = $goods->name;
                    $orderGoods->price = $goods->shop_price;
                    $orderGoods->logo = $goods->logo;
                    $orderGoods->amount = $amount;
                    $orderGoods->total = $amount*($goods->shop_price);
                    $orderGoods->save(0);
                    $v->delete();
                    $goods->stock -= $amount;
                    $goods->save();
                }
                //提交事务
                $transaction->commit();
            }catch (Exception $e){
                //回滚
                $transaction->rollBack();
                return $e->getMessage();
            }
            return 1;
        }
        $addresses = Address::find()->all();
        return $this->render('add',['addresses'=>$addresses]);
    }
}