<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 14:00
 */

namespace backend\controllers;


use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class BrandController extends Controller
{
    public function actionList(){

        $pagination = new Pagination();
        $condition = Brand::find()->where(['<>','status','-1']);
        $total = $condition->count();
        $pageSize = 2;
        $pagination->totalCount = $total;
        $pagination->pageSize = $pageSize;
        $brands = $condition->limit($pagination->limit)->offset($pagination->offset)->all();
        return $this->render('list',['brands'=>$brands,'pagination'=>$pagination]);
    }
    public function actionAdd(){
        $brand = new Brand();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $brand->load($request->post());
            $imgFile = UploadedFile::getInstance($brand,'imgFile');
            if ($brand->validate()){
                $ext = $imgFile->extension;
                $file = '/images/'.uniqid().'.'.$ext;
                $imgFile->saveAs(\Yii::getAlias('@webroot').$file);
                $brand->logo = $file;
                $brand->save(0);
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/list']);
            }else{
                var_dump($brand->getErrors());die;
            }
        }
        return $this->render('add',['brand'=>$brand]);
    }
    public function actionEdit($id){
        $brand = Brand::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $brand->load($request->post());
            $imgFile = UploadedFile::getInstance($brand,'imgFile');
            if ($brand->validate()){
                $ext = $imgFile->extension;
                $file = '/images/'.uniqid().'.'.$ext;
                $imgFile->saveAs(\Yii::getAlias('@webroot').$file);
                $brand->logo = $file;
                $brand->save(0);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/list']);
            }else{
                var_dump($brand->getErrors());die;
            }
        }
        return $this->render('edit',['brand'=>$brand]);
    }
    public function actionDelete(){
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $brand = Brand::updateAll(['status'=>-1],['id'=>$id]);
        if ($brand){
            return 1;
        }else{
            return -1;
        }
    }
}