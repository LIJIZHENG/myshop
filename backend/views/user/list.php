<div class="container">
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success">新增</a>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($users as $user):?>
            <tr>
                <td><?=$user->id?></td>
                <td><?=$user->username?></td>
                <td><?=$user->email?></td>
                <td><?=$user->status?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['edit','id'=>$user->id])?>" class="btn btn-warning">修改</a>
                    <a href="javascript:;" data-id="<?=$user->id?>" class="btn btn-danger del">删除</a>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
    <?=\yii\widgets\LinkPager::widget(['pagination'=>$pagination])?>
</div>
<?php
/**
 * @var $this \yii\web\View
 */
$this->registerJs(
    <<<JS
    $('.del').click(function() {
        if (confirm('是否删除')){
          var id = $(this).attr('data-id');
          var that = this;
          $.post('delete',{'id':id},function(data) {
            if (data){
                $(that).closest('tr').remove();
                alert('删除成功')
            }else {
                alert('删除失败')
            }
          })
        }
      
    })
JS
);