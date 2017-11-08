<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'name')->textInput();
//LOGO图片
echo $form->field($goods,'logo')->hiddenInput();
//引入css和js
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('@web'.'/webuploader/webuploader.css');
$this->registerJsFile('@web'.'/webuploader/webuploader.js',['depends'=>\yii\web\JqueryAsset::className()]);
$url = \yii\helpers\Url::to(['brand/upload']);
$qiurl = "http://oywgoal5u.bkt.clouddn.com/";
$this->registerJs(
    <<<JS
// 初始化Web Uploader
var uploader = WebUploader.create({

// 选完文件后，是否自动上传。
auto: true,

// swf文件路径
swf: '/js/Uploader.swf',

// 文件接收服务端。
server: "{$url}",

// 选择文件的按钮。可选。
// 内部根据当前运行是创建，可能是input元素，也可能是flash.
pick: '#filePicker',

// 只允许选择图片文件。
accept: {
title: 'Images',
extensions: 'gif,jpg,jpeg,bmp,png',
mimeTypes: 'image/*'
}
});
// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader.on( 'uploadSuccess', function( file,response) {
//$( '#'+file.id ).addClass('upload-state-done');
//回显图片
$('#upImage').attr('src',"{$qiurl}"+response.url);
//添加到表单
$('#goods-logo').val(response.url);
//取消修改时的图片回显
if ($('#getImage').length>0){
    $('#getImage').attr('src','');
}
});
JS
)
?>
<div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
</div>
<div><img id="upImage" width="200px"></div>
<?php
//商品分类
echo $form->field($goods,'goods_category_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';

//zTree
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$nodes = \backend\models\GoodsCategory::getNodes();
$this->registerJs(
    <<<JS
        var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
                }
            },
            callback: {
		        onClick: function(event, treeId, treeNode) {
		          $('#goods-goods_category_id').val(treeNode.id);
		        }
	        }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes ={$nodes};
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            zTreeObj.expandAll(true);
JS
);
echo $form->field($goods,'brand_id')->dropDownList(\backend\models\Brand::getBrands());
echo $form->field($goods,'market_price')->textInput();
echo $form->field($goods,'shop_price')->textInput();
echo $form->field($goods,'stock')->textInput();
echo $form->field($goods,'is_on_sale')->radioList(['1'=>'在售','0'=>'下架']);
echo $form->field($goods,'sort')->textInput();
echo $form->field($goodsIntro,'content')->widget('kucha\ueditor\UEditor');
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();