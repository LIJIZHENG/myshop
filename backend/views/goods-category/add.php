<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($gCategories,'name')->textInput();
echo $form->field($gCategories,'parent_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';
//zTree
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$nodes = \backend\models\GoodsCategory::getNodes();
$parent_id = empty($gCategories->parent_id)?0:"{$gCategories->parent_id}";
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
		          $('#goodscategory-parent_id').val(treeNode.id);
		        }
	        }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes ={$nodes};
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            zTreeObj.expandAll(true);
            var node = zTreeObj.getNodesByParam('parent_id',{$parent_id});
            zTreeObj.selectNode(node[0]);
JS
);
echo $form->field($gCategories,'intro')->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();