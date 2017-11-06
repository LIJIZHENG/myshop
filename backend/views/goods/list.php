<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>商品名称</th>
            <th>货号</th>
            <th>LOGO图片</th>
            <th>商品分类</th>
            <th>品牌分类</th>
            <th>市场价格</th>
            <th>商品价格</th>
            <th>库存</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($goods as $v):?>
            <tr>
                <td><?=$v->name?></td>
                <td><?=$v->sn?></td>
                <td><img src="<?=$v->logo?>" width="200px"></td>
                <td><?=$v->goods_category_id?></td>
                <td><?=$v->brand_id?></td>
                <td><?=$v->market_price?></td>
                <td><?=$v->shop_price?></td>
                <td><?=$v->stock?></td>
                <td><?=$v->create_time?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['goods-gallery/list','id'=>$v->id])?>" class="btn btn-default">相册</a>
                    <a href="<?=\yii\helpers\Url::to(['goods-intro','id'=>$v->id])?>" class="btn btn-info">查看</a>
                    <a href="<?=\yii\helpers\Url::to(['edit','id'=>$v->id])?>" class="btn btn-warning">编辑</a>
                    <a href="javascript:;" data-id="<?=$v->id?>" class="btn btn-danger del">删除</a>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<?php
/**
 * @var $this \yii\web\View
 */
$this->registerJs(
        <<<JS
    $('.del').click(function() {
      var id = $(this).attr('data-id');
      var that = this;
      $.post('delete',{'id':id},function(data) {
        if (data == 1){
            $(that).closest('tr').remove();
            alert('删除成功');
        }else{
            alert('删除失败');
        }
      })
    })
JS

);