<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,'name')->textInput();
echo $form->field($brand,'intro')->textarea();
echo $form->field($brand,'imgFile')->fileInput();
echo $form->field($brand,'sort')->textInput();
echo $form->field($brand,'status')->radioList(['0'=>'隐藏','1'=>'显示']);
echo \yii\helpers\Html::submitInput('修改',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();