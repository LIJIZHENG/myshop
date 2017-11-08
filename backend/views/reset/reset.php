<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($reset,'password')->passwordInput();
echo $form->field($reset,'newPassword')->passwordInput();
echo $form->field($reset,'rePassword')->passwordInput();
echo \yii\bootstrap\Html::submitInput('修改',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();