<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($user,'username')->textInput();
if  ($user->isNewRecord){
    echo $form->field($user,'password')->passwordInput();
}
echo $form->field($user,'email')->textInput();
echo $form->field($user,'status')->radioList(['1'=>'启用','0'=>'禁用']);
echo $form->field($user,'roles',['inline'=>true])->checkboxList(\backend\models\User::getRoles());
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();