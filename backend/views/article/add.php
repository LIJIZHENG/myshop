<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($article,'name')->textInput();
echo $form->field($article,'intro')->textarea();
echo $form->field($article,'article_category_id')->dropDownList(\backend\models\ArticleCategory::getCategories());
echo $form->field($article,'sort')->textInput();
echo $form->field($article,'status')->radioList(['0'=>'隐藏','1'=>'显示']);
echo $form->field($content,'content')->textarea();
echo \yii\helpers\Html::submitInput('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();