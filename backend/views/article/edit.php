<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($article,'name')->textInput();
echo $form->field($article,'intro')->textarea();
echo $form->field($article,'article_category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\ArticleCategory::find()->where(['<>','status',-1],'id','name')));
echo $form->field($article,'sort')->textInput();
echo $form->field($article,'status')->radioList(['0'=>'隐藏','1'=>'显示']);
echo $form->field($content,'content')->textarea();
echo \yii\helpers\Html::submitInput('修改',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();