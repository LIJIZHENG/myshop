<div class="container">
    <a href="<?=\yii\helpers\Url::to(['article-category/add'])?>" class="btn btn-success">新增</a>
    <table class="table table-bordered">
        <tr>
            <th>文章分类</th>
            <th>简介</th>
            <th>排序</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($aCategories as $aCategory):?>
            <tr>
                <td><?=$aCategory['name']?></td>
                <td><?=$aCategory['intro']?></td>
                <td><?=$aCategory['sort']?></td>
                <td><?=$aCategory['status']==1?'显示':'隐藏'?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['article-category/edit','id'=>$aCategory['id']])?>" class="btn btn-warning">修改</a>
                    <a href="javascript:;" class="btn btn-danger del" data-id="<?=$aCategory['id']?>">删除</a>
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
    if (confirm('是否要删除?')){
        var id = $(this).attr('data-id');
        var that = this;
        $.post('delete',{"id":id},function(data) {
            if (data == 1){
                $(that).closest('tr').remove();
            }else if (data == 0){
                alert('删除失败,该分类下有文章不能删除');
            }else{
                alert('删除失败');
            }
      })
    }
})
JS
);

