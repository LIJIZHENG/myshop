<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($user,'username')->textInput();
echo $form->field($user,'password')->passwordInput();
echo $form->field($user,'rePassword')->passwordInput();
echo $form->field($user,'email')->textInput();
echo $form->field($user,'status')->radioList(['1'=>'启用','0'=>'禁用']);
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();