<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContractSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contract-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'start_contract') ?>

    <?= $form->field($model, 'duration_contract') ?>

    <?= $form->field($model, 'id_contract_type') ?>

    <?= $form->field($model, 'id_employee') ?>

    <?php // echo $form->field($model, 'id_department') ?>

    <?php // echo $form->field($model, 'id_job_alocation') ?>

    <?php // echo $form->field($model, 'id_jobtitle') ?>

    <?php // echo $form->field($model, 'id_jobrole') ?>

    <?php // echo $form->field($model, 'id_division') ?>

    <?php // echo $form->field($model, 'number_contract') ?>

    <?php // echo $form->field($model, 'basic_salary') ?>

    <?php // echo $form->field($model, 'doh') ?>

    <?php  echo $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
