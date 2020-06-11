<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SplSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spl-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_spl') ?>

    <?= $form->field($model, 'start_lembur') ?>

    <?= $form->field($model, 'end_lembur') ?>

    <?= $form->field($model, 'so') ?>

    <?php // echo $form->field($model, 'nama_pekerjaan') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'satuan') ?>

    <?php // echo $form->field($model, 'employee_emp_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
