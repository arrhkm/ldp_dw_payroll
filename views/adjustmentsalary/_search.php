<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdjustmentSalarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adjustment-salary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_adjustment') ?>

    <?= $form->field($model, 'value_adjustment') ?>

    <?= $form->field($model, 'code_adjustment') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'id_employee') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
