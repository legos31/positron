<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Books $model */

$this->title = 'Create Books';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
