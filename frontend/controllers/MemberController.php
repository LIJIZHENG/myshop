<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 15:33
 */

namespace frontend\controllers;


use frontend\components\Sms;
use frontend\models\Member;
use yii\web\Controller;

class MemberController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionRegister(){
        $member = new Member();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $member->load($request->post(),'');
            if ($member->validate()){
                $member->password_hash = \Yii::$app->security->generatePasswordHash($member->password_hash);
                $member->status = 1;
                $member->auth_key = \Yii::$app->security->generateRandomString();
                $member->created_at = time();
                $member->save(0);
                return $this->redirect(['login/login']);
            }else{
                var_dump($member->getErrors());die;
            }
        }
        return $this->render('regist');
    }
    public function actionCheckName(){
        $request = \Yii::$app->request;
        $username = $request->post('username');
        $member = Member::findOne(['username'=>$username]);
        if ($member){
            return 'false';
        }
         return 'true';
    }
    public function actionSendSms()
    {
        $phone = \Yii::$app->request->post('phone');
        //短信防刷功能
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $rest = $redis->ttl('captcha_'.$phone);
        if ($rest > 4*60){
            return 0;
        }

        $code = mt_rand(1000,9999);
        $response = Sms::sendSms(
            "麦mall", // 短信签名
            "SMS_109395454", // 短信模板编号
            $phone, // 短信接收者
            Array(  // 短信模板中字段的值
                "code" => $code,
            )
        );

        $redis->set('captcha_'.$phone,$code,5*60);
        if ($response->Code == 'OK'){
            return 1;
        }
        return -1;
//        echo "发送短信(sendSms)接口返回的结果:\n";
//        print_r($response);
    }
    public function actionCheckCaptcha(){
        $request = \Yii::$app->request;
        $captcha = $request->post('captcha');
        $phone = $request->post('tel');
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $sms = $redis->get('captcha_'.$phone);
        if ($sms){
            if ($sms == $captcha){
                return 'true';
            }else{
                return "false";
            }
        }
        return "false";
    }
}