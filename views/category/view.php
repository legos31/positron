<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Categories $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<h3>Child category if isset</h3>


<ul class="list-group m-3">
    <?php if ($model->children): ?>
    <?php foreach ($model->children as $child) : ?>
        <li class="list-group-item"><a href="<?= Url::to(['category/view', 'id' => $child->id])?>" ><?=$child->name . PHP_EOL?></a></li>
    <?php endforeach; ?>
    <?php endif; ?>

</ul>

<div class="categories-view">

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
            'id',
            'name',
        ],
    ]) ?>

</div>
<h3>Books</h3>
<ul class="list-group">
<?php foreach ($model->books as $book) : ?>
    <li class="list-group-item"><a href="<?= Url::to(['book/view', 'id' => $book->id])?>" ><?=$book->title . PHP_EOL?></a></li>
<?php endforeach; ?>

</ul>
