<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 15:45
 */

namespace frontend\controllers;


use yii\web\Controller;

class AddressController extends Controller
{
    public function actionIndex(){
        return $this->render('address');
    }
    public function actionAdd(){
        $request = \Yii::$app->request;
        $data = $request->post();
        var_dump($data);
        die;
    }
}