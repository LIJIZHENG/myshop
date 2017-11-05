<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'name')->textInput();
echo $form->field($goods,'sn')->textInput();
//LOGO图片

//商品分类
echo $form->field($brand,'brand_id')->dropDownList();
echo $form->field($goods,'market_price')->textInput();
echo $form->field($goods,'shop_price')->textInput();
echo $form->field($goods,'stock')->textInput();
echo $form->field($goods,'is_on_sale')->radioList(['1'=>'在售','0'=>'下架']);
echo $form->field($goods,'status')->hiddenInput();
echo $form->field($goods,'sort')->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();