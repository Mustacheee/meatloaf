<?php

use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\web\JsExpression;

$form = ActiveForm::begin();

?>

<?= $form->field($model, 'date')->widget(DatePicker::className()); ?>

<?= $form->field($model, 'time')->textInput() ?>

<?= $form->field($model,  'count')->textInput() ?>

<?= $form->field($model, 'restaurant_name')->textInput() ?>

<?= $form->field($model, 'restaurant_link')->textInput() ?>

<?= $form->field($model, 'location_id')->widget(Select2::class, [
    'options' => ['placeholder' => 'Select a location for delivery ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 2,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => '/location/get-locations',
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ],
]) ?>

<?= $form->field($model, 'manager_id')->widget(
    Select2::class, [
    'options' => ['placeholder' => 'Select a manager ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 2,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => '/user/get-managers',
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ],
]) ?>

<?= $form->field($model, 'restrictions')->widget(MultipleInput::className()) ?>

<?= $form->field($model, 'notes')->textarea() ?>

<?= Html::submitButton('Submit Order') ?>

<?php
ActiveForm::end();
