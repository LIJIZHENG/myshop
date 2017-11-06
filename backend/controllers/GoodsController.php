<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 22:26
 */

namespace backend\controllers;


use backend\models\Goods;
use backend\models\GoodsDayCount;
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
        $goodsIntro = new GoodsIntro();
        //生成sn
        $date = date('Y-m-d');
        $date1 = date('Ymd');
        $goodsDayCount = new GoodsDayCount();
        $goodsCount = $goodsDayCount->findOne(['day'=>$date]);
        if ($goodsCount){
            $count = $goodsCount->count;
            $newCount = sprintf('%05s',$count+1);
            $goods->sn = $date1.$newCount;
            $count += 1;
//            $goodsDayCount->day = $date;
            $result =1;
        }else{
            $goods->sn = $date1.'00001';
            $count = 1;
//            $goodsDayCount->count = 1;
//            $goodsDayCount->day = $date;
            $result =0;
        }
        $request = \Yii::$app->request;
        if ($request->isPost){
            $goods->load($request->post());
            $goodsIntro->load($request->post());
            if ($goods->validate() && $goodsIntro->validate()){
                $goods->create_time = time();
                $goods->status = 1;
                $goods->save();
                $goodsIntro->save();
                if ($result ==1){
                    $goodsDayCount->updateAll(['count'=>$count],['day'=>$date]);
                }else{
                    $goodsDayCount->save();
                }

                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }else{
                var_dump($goods->getErrors());
                var_dump($goodsIntro->getErrors());
                var_dump($goodsDayCount->getErrors());
                die;
            }
        }
        return $this->render('add',['goods'=>$goods,'goodsIntro'=>$goodsIntro]);
    }
    public function actionEdit($id){
        $goods = Goods::findOne(['id'=>$id]);
        $goodsIntro = GoodsIntro::findOne(['goods_id'=>$id]);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $goods->load($request->post());
            $goodsIntro->load($request->post());
            if ($goods->validate() && $goodsIntro->validate()){
                $goods->create_time = time();
                $goods->status = 1;
                $goods->save();
                $goodsIntro->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }else{
                var_dump($goods->getErrors());
                var_dump($goodsIntro->getErrors());
                die;
            }
        }
        return $this->render('edit',['goods'=>$goods,'goodsIntro'=>$goodsIntro]);
    }
    public function actionDelete(){
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $num = Goods::updateAll(['status'=>0],['id'=>$id]);
        if ($num){
            return 1;
        }else{
            return 0;
        }
    }
    public function actionGoodsIntro($id){
        $content = GoodsIntro::findOne(['goods_id'=>$id]);
        return $this->render('intro',['content'=>$content]);
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
}