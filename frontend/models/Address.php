<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 9:18
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class Address extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name','province','city','area','detail','tel'],'required']
        ];
    }
}