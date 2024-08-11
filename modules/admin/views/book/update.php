<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Books $model */

$this->title = 'Update Books: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="books-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
