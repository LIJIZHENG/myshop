<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($permission,'name')->textInput();
echo $form->field($permission,'description',['inline'=>true])->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();