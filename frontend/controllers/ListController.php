<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 19:36
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\web\Controller;

class ListController extends Controller
{
//    public function actionList(){
//        $get = \Yii::$app->request->get();
//        $ids = 0;
//        //查询顶级分类下的三级分类id
//        if (isset($get['tree'])){
//            $ids = GoodsCategory::find()->select(['id'])->where(['tree'=>$get['tree']])->andWhere(['depth'=>2])->asArray()->all();
//        }
//        //查询二级分类下的三级分类id
//        if (isset($get['lft'])){
//            $ids = GoodsCategory::find()->select(['id'])->where(['>','lft',$get['lft']])->andWhere(['<','rgt',$get['rgt']])->andWhere(['depth'=>2])->asArray()->all();
//        }
//        //获取三级分类id
//        if (isset($get['id'])){
//            $ids = [$get];
//        }
//        //拼接where条件
//        $where = " where ";
//        $i = 0;
//        foreach ($ids as $id){
//            if ($i == 0){
//                $where .= "goods_category_id = {$id['id']}";
//                $i++;
//            }else{
//                $where .= " or goods_category_id={$id['id']}";
//            }
//        }
//        $sql = "select * from goods {$where} and status=1";
//        $goods = Goods::findBySql($sql)->all();
//        return $this->render('list',['goods'=>$goods]);
//    }
    public function actionList($id){
        $category = GoodsCategory::findOne(['id'=>$id]);
        $ids ='';
        if ($category->depth == 2){
            $ids = [$id];
        }else{
            $ids = $category->children()->andWhere(['depth'=>2])->column();
        }
        $query = Goods::find()->where(['in','goods_category_id',$ids]);
        $pager = new Pagination();
        $pager->pageSize = 1;
        $pager->totalCount = $query->count();
        $goods = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('list',['goods'=>$goods,'pager'=>$pager,'id'=>$id]);
    }

}