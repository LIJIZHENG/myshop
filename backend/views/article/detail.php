<div class="container">
    <h2><?=$base->name?></h2>
    <hr />
    <p><?=$detail->content?></p>
</div>
<a href="<?=\yii\helpers\Url::to(['article/list'])?>" class="btn btn-info">返回文章列表</a>