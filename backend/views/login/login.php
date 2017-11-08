<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($userForm,'username')->textInput();
echo $form->field($userForm,'password')->passwordInput();
echo $form->field($userForm,'captcha')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>'login/captcha'
]);
echo $form->field($userForm,'rememberMe')->checkbox();
echo \yii\bootstrap\Html::submitInput('登录',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();