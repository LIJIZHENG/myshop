<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 15:45
 */

namespace frontend\controllers;


use frontend\models\Address;
use yii\web\Controller;

class AddressController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
        $member_id = \Yii::$app->user->identity->getId();
        $addresses = Address::find()->where(['member_id'=>$member_id])->all();
        return $this->render('address',['addresses'=>$addresses]);
    }
    public function actionAdd(){
        $request = \Yii::$app->request;
        $data = $request->post();
        $address = new Address();
        $address->load($data,'');
        if ($address->validate()){
            $address->member_id = \Yii::$app->user->identity->getId();
            if ($address->status == 1){
                $defult = Address::findOne(['member_id'=>$address->member_id,'status'=>1]);
                $defult->status = 0;
                $defult->save();
            }
            $address->save();
            return $this->redirect(['index']);
        }else{
            var_dump($address->getErrors());die;
        }
    }
    public function actionDelete(){
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $address = Address::findOne(['id'=>$id]);
        if ($address){
            $result = $address->delete();
            if ($result){
                return 1;
            }else{
                return 0;
            }
        }
    }
    //设置默认地址
    public function actionSetDefault(){
        $member_id = \Yii::$app->user->identity->id;
        $oldAddress = Address::findOne(['member_id'=>$member_id,'status'=>1]);
        if ($oldAddress){
            $oldAddress->status = 0;
            $oldAddress->save();
        }

        $id = \Yii::$app->request->get('id');
        $address = Address::findOne(['id'=>$id]);
        $address->status = 1;
        $address->save();
        return $this->redirect(['index']);
    }
    public function actionEdit(){
        $request = \Yii::$app->request;
        $member_id = \Yii::$app->user->identity->getId();
        $addresses = Address::find()->where(['member_id'=>$member_id])->all();
        if ($request->isPost){
            $id = $request->post('id');
            $address = Address::findOne(['id'=>$id]);
            $address->load($request->post(),'');
            if ($request->post('status') === null){
                $address->status = 0;
            }
//            var_dump($address);die;
            if ($address->validate()){
                $address->member_id = \Yii::$app->user->identity->getId();
                if ($address->status == 1 && $address->getOldAttribute('status') !=1){
                    $defult = Address::findOne(['member_id'=>$address->member_id,'status'=>1]);
                    if ($defult){
                        $defult->status = 0;
                        $defult->save();
                    }
                }
                $address->save();
                return $this->redirect(['index']);
            }else{
                var_dump($address->getErrors());die;
            }
        }
        $id = $request->get('id');
        $address = Address::findOne(['id'=>$id]);
        return $this->render('address',['editAddress'=>$address,'addresses'=>$addresses]);
    }
}