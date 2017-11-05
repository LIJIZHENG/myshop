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
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

class BrandController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {

        $pagination = new Pagination();
        $condition = Brand::find()->where(['<>', 'status', '-1']);
        $total = $condition->count();
        $pageSize = 2;
        $pagination->totalCount = $total;
        $pagination->pageSize = $pageSize;
        $brands = $condition->limit($pagination->limit)->offset($pagination->offset)->all();
        return $this->render('list', ['brands' => $brands, 'pagination' => $pagination]);
    }

    public function actionAdd()
    {
        $brand = new Brand();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $brand->load($request->post());
            if ($brand->validate()) {
                $brand->save(0);
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['brand/list']);
            } else {
                var_dump($brand->getErrors());
                die;
            }
        }
        return $this->render('add', ['brand' => $brand]);
    }

    public function actionEdit($id)
    {
        $brand = Brand::findOne(['id' => $id]);
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $brand->load($request->post());
            if ($brand->validate()) {
                $brand->save();
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['brand/list']);
            } else {
                var_dump($brand->getErrors());
                die;
            }
        }
        return $this->render('edit', ['brand' => $brand]);
    }

    public function actionDelete()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $brand = Brand::updateAll(['status' => -1], ['id' => $id]);
        if ($brand) {
            return 1;
        } else {
            return -1;
        }
    }

    //接收图片并上传到七牛云服务器
    public function actionUpload()
    {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $image = UploadedFile::getInstanceByName('file');
            $ext = $image->extension;
            $file = '/images/'. uniqid().'.'.$ext;
            $image->saveAs(\Yii::getAlias('@webroot').$file);
            // 需要填写你的 Access Key 和 Secret Key
            $accessKey = "cPaipIAPXYXiZax5I56mIMdLSq0DjwS1SRMlAJDb";
            $secretKey = "Eo9aE5O7och_RNaucpZULG0enVVJgwg4dE3OglP8";
            $bucket = "myshop";
            // 构建鉴权对象
            $auth = new Auth($accessKey, $secretKey);
            // 生成上传 Token
            $token = $auth->uploadToken($bucket);
            // 要上传文件的本地路径
            $filePath = \Yii::getAlias('@webroot').$file;
            // 上传到七牛后保存的文件名
            $key = $file;
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 putFile 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//            echo "\n====> putFile result: \n";
            if ($err !== null) {
//                var_dump($err);
                return Json::encode(['error' => $err]);
            } else {
//                var_dump($ret);
                return Json::encode(['url'=>$file]);
            }
        }
    }
}