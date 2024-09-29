<?php

use app\models\variations\ProductTypesProps;
use app\models\variations\VariationItems;
use app\models\variations\Variations;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\variations\Variations $model */

$this->title = 'Update Variations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Variations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="variations-update">

    <?php
    $data = [];
    $dataList = VariationItems::find()->andWhere(['variation_id' => $model->id])->all();
//dd($model->_articles, $model->productsArticle);
    ?>

    <div class="variations-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->textInput() ?>
        <?php
            $url = Url::to(['variation/get-article']);
            //dd($model->_articles, ArrayHelper::map($model->products, 'id', 'gcode'),);
        ?>

        <?php
        echo $form->field($model, '_articles')->widget(Select2::classname(), [
            'data' =>  ArrayHelper::map($model->products, 'id', 'gcode'),
            'options' => ['multiple'=>true, 'placeholder' => 'Search...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(gcode) { return gcode.text; }'),
                'templateSelection' => new JsExpression('function (gcode) { return gcode.text; }'),
            ],
        ]);

        echo $form->field($model, '_props')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(ProductTypesProps::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Выберите аттрибуты товаров ...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 100
            ],
        ])->label('Tag Multiple');

        ?>

        <?= $form->field($model, 'active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
