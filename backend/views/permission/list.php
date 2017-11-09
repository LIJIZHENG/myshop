<div class="container">
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success">新增</a>
    <table id="listTable" class="display">
        <thead>
            <tr>
                <th>名称(路由)</th>
                <th>描述</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $permission):?>
                <tr>
                    <td><?=$permission->name?></td>
                    <td><?=$permission->description?></td>
                    <td><?=date('Y-m-d H:i:s',$permission->createdAt)?></td>
                    <td><?=date('Y-m-d H:i:s',$permission->updatedAt)?></td>
                    <td>
                        <a href="<?=\yii\helpers\Url::to(['edit','name'=>$permission->name])?>" class="btn btn-warning">修改</a>
                        <a href="javascript:;" data-name="<?=$permission->name?>" class="btn btn-danger del">删除</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>

    </table>
</div>
<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile(Yii::getAlias('@web').'/datatables/css/jquery.dataTables.css');
$this->registerJsFile(Yii::getAlias('@web').'/datatables/datatables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJsFile(Yii::getAlias('@web').'/datatables/js/jquery.dataTables.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs(
        <<<JS
    $(document).ready( function () {
           $('#listTable').DataTable({
        "oLanguage": {
            "sLengthMenu": "每页显示 _MENU_ 条记录",
            "sZeroRecords": "对不起，查询不到任何相关数据",
            "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_条记录",
            "sInfoEmtpy": "找不到相关数据",
            "sInfoFiltered": "数据表中共为 _MAX_ 条记录)",
            "sProcessing": "正在加载中...",
            "sSearch": "搜索",
            "oPaginate": {
                "sFirst": "第一页",
                "sPrevious":" 上一页 ",
                "sNext": " 下一页 ",
                "sLast": " 最后一页 "
                }
            }
        });
    } );
    $('.del').click(function() {
      if (confirm('是否删除?')){
          var name = $(this).attr('data-name');
          var that = this;
          $.post('delete',{'name':name},function(data) {
            if (data){
                $(that).closest('tr').remove();
                alert('删除成功');
            }else{
                alert('删除失败');
            }
          })
      }
    })
JS
);