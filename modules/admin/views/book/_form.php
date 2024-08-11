<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pageCount')->textInput() ?>

    <?= $form->field($model, 'publishedDate')->textInput() ?>

    <?= $form->field($model, 'shortDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'longDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'file')->fileInput() ?>
    <?php
    if (isset($model->thumbnailUrl)) {
        echo Html::img('@web/images/books/' . Html::encode($model->thumbnailUrl), ['style' => 'width:200px']);
        echo Html::tag('p', $model->thumbnailUrl);
    } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
