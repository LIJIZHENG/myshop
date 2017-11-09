<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($role,'name')->textInput();
echo $form->field($role,'description')->textInput();
echo $form->field($role,'permissions',['inline'=>true])->checkboxList(\backend\models\RoleForm::getPermissions());
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();