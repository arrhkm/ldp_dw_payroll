<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContractHistoriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contract-histories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'start_contract') ?>

    <?= $form->field($model, 'duration_contract') ?>

    <?= $form->field($model, 'id_employee') ?>

    <?= $form->field($model, 'number_contract') ?>

    <?php // echo $form->field($model, 'doh') ?>

    <?php // echo $form->field($model, 'basic_salary') ?>

    <?php // echo $form->field($model, 'set_default')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
