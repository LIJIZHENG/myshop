<div class="container">
    <form class="form-inline" action="<?=\yii\helpers\Url::to(['list'])?>" method="get">
        <div class="col-lg-2">
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="商品名称" value="<?=$search['name']?>">
        </div>
        </div>
        <div class="col-lg-2">
        <div class="form-group">
            <input type="text" class="form-control" id="sn" name="sn" placeholder="货号" value="<?=$search['sn']?>">
        </div>
        </div>
        <div class="col-lg-2">
        <div class="form-group">
            <input type="text" class="form-control" id="lowPrice"  name="lowPrice" placeholder="最低价格" value="<?=$search['lowPrice']?>">
        </div>
        </div>
        <div class="col-lg-3">
            <div class="input-group">
                <input type="text" class="form-control" id="highPrice" name="highPrice" placeholder="最高价格" value="<?=$search['highPrice']?>">
                <span class="input-group-btn">
        <button type="submit" class="btn btn-default" id="search" type="button"><span class="glyphicon glyphicon-search"></span></button>
      </span>
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
    </form>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success">新增</a>
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
                <td><?=$v->goodsCategory->name?></td>
                <td><?=$v->brand->name?></td>
                <td><?=$v->market_price?></td>
                <td><?=$v->shop_price?></td>
                <td><?=$v->stock?></td>
                <td><?=date('Y-m-d H:i:s',$v->create_time)?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['goods-gallery/list','id'=>$v->id])?>" class="btn btn-default">相册</a>
                    <a href="<?=\yii\helpers\Url::to(['goods-intro','id'=>$v->id])?>" class="btn btn-info">查看</a>
                    <a href="<?=\yii\helpers\Url::to(['edit','id'=>$v->id])?>" class="btn btn-warning">编辑</a>
                    <a href="javascript:;" data-id="<?=$v->id?>" class="btn btn-danger del">删除</a>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php echo \yii\widgets\LinkPager::widget(['pagination'=>$pagination]);?>
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
    }); 
JS

);