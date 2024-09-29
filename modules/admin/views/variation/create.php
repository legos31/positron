<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\variations\Variations $model */

$this->title = 'Create Variations';
$this->params['breadcrumbs'][] = ['label' => 'Variations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="variations-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->textInput() ?>
        <?php
        $url = Url::to(['variation/get-article']);

        ?>

        <?php

        echo $form->field($model, '_articles')->widget(Select2::classname(), [
            'data' => [],
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

        $model->_props =  ['red', 'green']; // initial value

        echo $form->field($model, '_props')->widget(Select2::classname(), [
            //'data' => $data,
            'options' => ['placeholder' => 'Выберите аттрибуты товаров ...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [':', ' '],
                'maximumInputLength' => 10
            ],
        ])->label('Tag Multiple');

//        echo $form->field($model, '_props')->dropDownList([
//                1 => 'list',
//                2 => 'gost'
//        ], ['multiple'=>'multiple',
//            'class'=>'chosen-select input-md required']);

        ?>

        <?= $form->field($model, 'active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php $this->registerJs(<<<JS
    $(document).ready(function() {
        // Обработчик изменения первого select
        $('#variations-_articles').on('change', function() {
            let articles = $(this).val();
            console.log(articles);

            // Очистка второго select
            $('#variations-_props').val(null).trigger('change');
            
            
            $.ajax({
                url: 'http://localhost:8000/admin/variation/test', // Путь к вашему PHP файлу
                method: 'POST',
                data: { value: articles },
                dataType: 'json',
                success:function(data){
                    $('#variations-_props').empty();
                    $.each(data, function(key, value){
                        $('#variations-_props').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });

            
    });
    });
JS
);