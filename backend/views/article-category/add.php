<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($aCategory,'name')->textInput();
echo $form->field($aCategory,'intro')->textarea();
echo $form->field($aCategory,'sort')->textInput();
echo $form->field($aCategory,'status')->radioList(['0'=>'隐藏','1'=>'显示']);
echo \yii\helpers\Html::submitInput('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();