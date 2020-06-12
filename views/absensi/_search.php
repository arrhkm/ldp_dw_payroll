<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AbsensiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="absensi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tgl') ?>

    <?= $form->field($model, 'emp_id') ?>

    <?= $form->field($model, 'jam_in') ?>

    <?= $form->field($model, 'jam_out') ?>

    <?= $form->field($model, 'ket_absen') ?>

    <?php // echo $form->field($model, 'timestamp_diff') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'loc_code') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
