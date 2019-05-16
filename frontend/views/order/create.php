<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;

$form = ActiveForm::begin();

?>

<?= $form->field($model, 'date')->widget(DatePicker::className()); ?>

<?= $form->field($model, 'time')->textInput() ?>

<?= $form->field($model,  'count')->textInput() ?>

<?= $form->field($model, 'restaurant_name')->textInput() ?>

<?= $form->field($model, 'restaurant_link')->textInput() ?>

<?= $form->field($model, 'location')->textInput() ?>

<?= $form->field($model, 'manager_email')->textInput() ?>

<?= $form->field($model, 'restrictions')->widget(MultipleInput::className()) ?>

<?= $form->field($model, 'notes')->textarea() ?>

<?= Html::submitButton('Submit Order') ?>

<?php
ActiveForm::end();
