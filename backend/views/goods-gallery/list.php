<?php
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
//$('#upImage').attr('src',"{$qiurl}"+response.url);
////添加到表单
//$('#goods-logo').val(response.url);
////取消修改时的图片回显
//if ($('#getImage').length>0){
//$('#getImage').attr('src','');
$.post('add',{'path':response.url},function() {
  
})
}
})
JS
)
    ?>
    <div id="uploader-demo">
        <!--用来存放item-->
        <div id="fileList" class="uploader-list"></div>
        <div id="filePicker">选择图片</div>
    </div>
    <div><img id="upImage" width="200px"></div>
    </div>
    <div id="content">
        <?php foreach($goodsGalleries as $goodsGallery):?>
        <img src="<?=$goodsGallery->path?>">
        <a href="javscript:;" data-id="<?=$goodsGallery->id?>" class="btn btn-danger">删除</a>
        <?php endforeach;?>
    </div>
