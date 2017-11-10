<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>名称</th>
            <th>地址\路由</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        <?php foreach ($menus as $menu):?>
            <tr>
                <td><?=str_repeat('-',($menu->depth)*3)?><?=$menu->name?></td>
                <td><?=$menu->route?></td>
                <td><?=$menu->sort?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['edit','id'=>$menu->id])?>" class="btn btn-warning">修改</a>
                    <a href="javascript:;" data-id="<?=$menu->id?>" class="btn btn-danger del">删除</a>
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
            if (data){
                $(that).closest('tr').remove();
                alert('删除成功');
            }else if(data == -1) {
                alert('该菜单下还有子菜单不能删除');
            }else{
                alert('删除失败');
            }
          })
        }
    })
JS

);