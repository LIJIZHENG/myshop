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
            <th>是否在售</th>
            <th>状态</th>
            <th>添加时间</th>
            <th>浏览次数</th>
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
                <td><?=$v->is_on_sale?></td>
                <td><?=$v->status?></td>
                <td><?=$v->create_time?></td>
                <td><?=$v->view_times?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['goods-gallery','id'=>$v->id])?>">相册</a>
                    <a href="<?=\yii\helpers\Url::to(['goods-intro','id'=>$v->id])?>">查看</a>
                    <a href="<?=\yii\helpers\Url::to(['edit','id'=>$v->id])?>">编辑</a>
                    <a href="<?=\yii\helpers\Url::to(['delete','id'=>$v->id])?>">删除</a>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>