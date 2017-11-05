<div class="container">
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info">新增</a>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>分类名称</th>
            <th>上级分类</th>
            <th>简介</th>
            <th>操作</th>
        </tr>
        <?php foreach($gCategories as $gCategory):?>
            <tr>
                <td><?=$gCategory->id?></td>
                <td><?=$gCategory->name?></td>
                <td><?=\backend\models\GoodsCategory::getParentName($gCategory->parent_id)?></td>
                <td><?=$gCategory->intro?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['edit','id'=>$gCategory->id])?>" class="btn btn-warning">修改</a>
                    <a href="javascript:;" class="btn btn-danger del" data-id="<?=$gCategory->id?>">删除</a>
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
      if (confirm('是否要删除?')){
          var id = $(this).attr('data-id');
          var that = this;
          $.post('delete',{'id':id},function(data) {
            if (data == 1){
                $(that).closest('tr').remove();
                alert('删除成功');
            }else if (data == 0){
                alert('该分类下还有子分类,不能删除');
            }else{
                alert('删除失败');
            }
          })
      }
    })
JS
);