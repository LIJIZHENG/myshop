<div class="container">
    <a href="<?=\yii\helpers\Url::to(['brand/add'])?>" class="btn btn-success">新增</a>
    <table class="table table-bordered">
        <tr>
            <th>名称</th>
            <th>品牌logo</th>
            <th>简介</th>
            <th>排序</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($brands as $brand):?>
            <tr>
                <td><?=$brand['name']?></td>
                <td><?=\yii\bootstrap\Html::img($brand['logo'],['width'=>100])?></td>
                <td><?=$brand['intro']?></td>
                <td><?=$brand['sort']?></td>
                <td><?=$brand['status']==1?'显示':'隐藏'?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['brand/edit','id'=>$brand['id']])?>" class="btn btn-warning">修改</a>
                    <a href="javascript:;" class="btn btn-danger del" data-id="<?=$brand['id']?>">删除</a>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
    <?=\yii\widgets\LinkPager::widget(['pagination'=>$pagination]);?>
</div>

<?php
$this->registerJs(
        <<<JS
$('.del').click(function() {
    confirm('是否要删除?');
    var id = $(this).attr('data-id');
    var that = this;
    $.post('delete',{"id":id},function(data) {
        if (data == 1){
            $(that).closest('tr').remove();
        }else{
            alert('删除失败');
        }
  })
})
JS
);

