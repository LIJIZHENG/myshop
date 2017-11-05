<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($gCategories,'name')->textInput();
echo $form->field($gCategories,'parent_id')->textInput();
echo $form->field($gCategories,'intro')->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();