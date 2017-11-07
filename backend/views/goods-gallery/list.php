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
// $('#upImage').attr('src',"{$qiurl}"+response.url);
////添加到表单
//$('#goods-logo').val(response.url);
////取消修改时的图片回显
//if ($('#getImage').length>0){
//$('#getImage').attr('src','');
$.post('add',{'path':response.url,'goods_id':{$goods_id}},function(data) {
    if (data){
        var content = '<div><img src="'+"{$qiurl}"+response.url+'" width="200px"><a href="javascript:;" data-id="'+data+'" class="btn btn-danger del">删除</a><div>';
        $(content).appendTo('#content');
        alert('上传成功');
    }else{
        alert('上传失败')
    }
});
});
$('#content').on('click','.del',function() {
    if (confirm('是否要删除')){
        var id = $(this).attr('data-id');
        var that = this;
        $.post('delete',{'id':id},function(data) {
          if (data){
              $(that).closest('div').remove();
              alert('删除成功');
          }else{
              alert('删除失败')
          }
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
    <div id="content">
        <?php foreach($goodsGalleries as $goodsGallery):?>
            <div>
                <img src="<?=$goodsGallery->path?>" width="200px">
                <a href="javscript:;" data-id="<?=$goodsGallery->id?>" class="btn btn-danger del">删除</a>
            </div>
        <?php endforeach;?>
    </div>
