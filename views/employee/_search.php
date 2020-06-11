<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'emp_id') ?>

    <?= $form->field($model, 'emp_name') ?>

    <?= $form->field($model, 'no_rekening') ?>

    <?= $form->field($model, 'kd_jabatan') ?>

    <?= $form->field($model, 'gaji_pokok') ?>

    <?php // echo $form->field($model, 'gaji_lembur') ?>

    <?php // echo $form->field($model, 'pot_jamsos') ?>

    <?php // echo $form->field($model, 't_jabatan') ?>

    <?php // echo $form->field($model, 't_masakerja') ?>

    <?php // echo $form->field($model, 't_insentif') ?>

    <?php // echo $form->field($model, 'pot_telat') ?>

    <?php // echo $form->field($model, 'uang_makan') ?>

    <?php // echo $form->field($model, 'start_work') ?>

    <?php // echo $form->field($model, 'start_contract') ?>

    <?php // echo $form->field($model, 'end_contract') ?>

    <?php // echo $form->field($model, 'lama_contract') ?>

    <?php // echo $form->field($model, 'emp_group') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
