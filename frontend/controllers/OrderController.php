<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 19:23
 */

namespace frontend\controllers;


use frontend\models\Address;
use yii\web\Controller;

class OrderController extends Controller
{
    public function actionOrder(){
        return $this->render('order');
    }
    public function actionAdd(){
        $addresses = Address::find()->all();
        return $this->render('add',['addresses'=>$addresses]);
    }
}