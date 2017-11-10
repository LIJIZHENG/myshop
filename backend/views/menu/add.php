<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($menu,'name')->textInput();
echo $form->field($menu,'parent_id')->dropDownList(\backend\models\Menu::getParent());
echo $form->field($menu,'route')->dropDownList(\backend\models\Menu::getPermissions());
echo $form->field($menu,'sort')->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();