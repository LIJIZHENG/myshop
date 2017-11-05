<div class="container">
    <a href="<?=\yii\helpers\Url::to(['article/add'])?>" class="btn btn-success">新增</a>
    <table class="table table-bordered">
        <tr>
            <th>文章标题</th>
            <th>简介</th>
            <th>文章分类</th>
            <th>排序</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($articles as $article):?>
            <tr>
                <td><?=$article['name']?></td>
                <td><?=$article['intro']?></td>
                <td><?=$article['article_category_id']?></td>
                <td><?=$article['sort']?></td>
                <td><?=$article['status']==1?'正常':'隐藏'?></td>
                <td><?=date('Y-m-d H:i:s',$article['create_time'])?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['article/edit','id'=>$article['id']])?>" class="btn btn-warning">修改</a>
                    <a href="javascript:;" class="btn btn-danger del" data-id="<?=$article['id']?>">删除</a>
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
            }else{
                alert('删除失败');
            }
      })
    } 
})
JS
);

