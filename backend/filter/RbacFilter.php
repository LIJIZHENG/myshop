<?php
namespace backend\filter;
use yii\base\ActionFilter;
use yii\web\HttpException;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 21:12
 */
class RbacFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if(!\Yii::$app->user->can($action->uniqueId)){
            //如果没有登录,则跳转到登录页面
            if(\Yii::$app->user->isGuest){
                return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
            }else{
                throw new HttpException(403,'对不起,您没有该操作权限');
                return false;
            }
        }
        return parent::beforeAction($action);
    }

}