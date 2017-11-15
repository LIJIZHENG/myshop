<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 15:08
 */

namespace frontend\models;


use yii\base\Model;
use yii\data\Pagination;
use yii\helpers\Url;

class ListPager extends Model
{
    public static function listPager($pager,$id){
        $pager->pageCount;
        $html = '';
        $html .='<div class="page mt20">
            <a href="'.Url::to(['list/list','page'=>1,'id'=>$id]).'">首页</a>
            <a href="'.Url::to(['list/list','page'=>($pager->page-1)<1?1:($pager->page-1),'id'=>$id]).'">上一页</a>';

        for ($i =1;$i<=$pager->pageCount;$i++){
            $html .='<a href="'.Url::to(['list/list','page'=>$i,'id'=>$id]).'" '.(($i==$pager->page)?'class="cur"':'').'>'.$i.'</a>';
        }
        $next = (($pager->page+1)>($pager->pageCount))?($pager->pageCount):($pager->page+1);
        $html .='<a href="'.Url::to(['list/list','page'=>$next,'id'=>$id]).'">下一页</a>
            <a href="'.Url::to(['list/list','page'=>$pager->pageCount,'id'=>$id]).'">尾页</a>&nbsp;&nbsp;
            <span>
					<em>共'.$pager->pageCount.'页&nbsp;&nbsp;到第 <input type="text" class="page_num" value=""/> 页</em>
					<a href="" class="skipsearch" href="javascript:;">确定</a>
				</span>
        </div>';
        return $html;
    }
}