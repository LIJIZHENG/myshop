<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/11
 * Time: 15:27
 */

namespace backend\controllers;


use yii\web\Controller;

class CommonController extends Controller
{
    public function beforeAction($action)
    {
        $action = \Yii::$app->controller->action->id;
        $controller = \Yii::$app->controller->id;
        $route = $controller.'/'.$action;
        if(!\Yii::$app->user->isGuest){

            if(\Yii::$app->user->can($route)){
                return true;
            }else{
                throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
            }
        }else{
            if ($route == 'login/login' | $route == 'login/captcha'){
                return true;
            }
            else{
                throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
            }
        }
    }
}