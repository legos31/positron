<?php

use app\models\Books;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Books $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'thumbnailUrl',
                'label' => 'Image',
                'value' => function (Books $model) {
                    return $model->thumbnailUrl ? Html::img(Yii::getAlias('@web') . '/images/books/' . $model->thumbnailUrl) : null;
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 40px'],

            ],
            'title',
            [
                'attribute' => 'categories',
                'value' => function (Books $model) {
                    $arrCategory = [];
                    foreach ($model->categories as $category) {
                       $arrCategory[] = Html::a(Html::encode($category->name), ['category/view', 'id' => $category->id]);
                    }
                   return implode(', ', $arrCategory);
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 40px'],
            ],
            'pageCount',
            'isbn',
        ],
    ]) ?>

</div>
