<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 15:10
 */

namespace backend\models;


use yii\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class GoodsCategory extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'name'=>'商品分类名',
            'parent_id'=>'上级分类',
            'intro'=>'简介'
        ];
    }
    public function rules()
    {
        return [
            [['name','parent_id',],'required'],
            ['intro','safe']
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new GoodsCategoryQuery(get_called_class());
    }
    //获取zTree需要的json数据
    public static function getNodes(){
        $nodes = self::find()->select(['id','name','parent_id'])->all();
        $nodes = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],$nodes);
        return Json::encode($nodes);
    }
    //获取上级分类名称
    public static function getParentName($parent_id){
        $parent = self::findOne(['id'=>$parent_id]);
        return empty($parent['name'])?'顶级分类':$parent['name'];
    }
//    public static function getChildren($id){
//        $children = self::find()->where(['parent_id'=>$id])->all();
//        return $children;
//    }
    public static function getIndexGoodsCategory(){
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $html = $redis->get('goods-category');
        if (!$html){
            //查询商品顶级分类
            $categories = self::find()->roots()->all();
            $html = '';
            foreach ($categories as $k1=>$category){
                $html .='<div class="cat '.($k1==0?'item1':'').'">
            <h3><a href="'.\yii\helpers\Url::to(['list/list','id'=>$category->id]).'">'.$category->name.'</a><b></b></h3>
            <div class="cat_detail">';
                //查询二级分类
                $categorytwo = $category->children(1)->all();
                foreach ($categorytwo as $k2=>$erji){
                    $html .=' <dl '.($k2==0?'class="dl_1st"':'').'>
                <dt><a href="'.\yii\helpers\Url::to(['list/list','id'=>$erji->id]).'">'.$erji->name.'</a></dt>
                <dd>';
                    //查询三级分类
                    $categorythree = $erji->children()->all();
                    foreach ($categorythree as $sanji){
                        $html .= '<a href="'.\yii\helpers\Url::to(['list/list','id'=>$sanji->id]).'">'.$sanji->name.'</a>';
                    }
                    $html .=' </dd></dl>';
                }
                $html .= '</div></div>';
            }
            $redis->set('goods-category',$html,24*3600);
        }
        return $html;
    }
}