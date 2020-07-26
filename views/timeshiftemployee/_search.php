<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TimeshiftEmployeeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeshift-employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_shift') ?>

    <?= $form->field($model, 'id_period') ?>

    <?= $form->field($model, 'id_employee') ?>

    <?= $form->field($model, 'start_hour') ?>

    <?php // echo $form->field($model, 'duration_hour') ?>

    <?php // echo $form->field($model, 'is_dayoff')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
