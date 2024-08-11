<?php

use app\models\Books;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <p>
        <?= Html::a('Create Books', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
                'attribute' => 'authors',
                'value' => function (Books $model) {

                    return $model->authors ? implode(', ', ArrayHelper::map($model->authors, 'id','name')) : null;
                },
                'format' => 'raw',
            ],
            //'authors',
            //'isbn',
            //'pageCount',
            //'publishedDate',
            //'thumbnailUrl',
            //'shortDescription:ntext',
            //'longDescription:ntext',
            [
                'attribute' => 'status',
                'filter' => $searchModel->getStatusesList(),
                'value' => function (Books $model) {
                    return $model->getStatusLabel($model->status);
                },
                'format' => 'raw',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Books $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
