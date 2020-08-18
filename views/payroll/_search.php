<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PayrollSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reg_number') ?>

    <?= $form->field($model, 'payroll_name') ?>

    <?= $form->field($model, 'tg_all') ?>

    <?= $form->field($model, 't_msker') ?>

    <?php // echo $form->field($model, 'i_um') ?>

    <?php // echo $form->field($model, 'i_tidak_tetap') ?>

    <?php // echo $form->field($model, 'cicilan_kasbon') ?>

    <?php // echo $form->field($model, 'pot_safety') ?>

    <?php // echo $form->field($model, 'pengurangan') ?>

    <?php // echo $form->field($model, 'penambahan') ?>

    <?php // echo $form->field($model, 'id_payroll_group') ?>

    <?php // echo $form->field($model, 'id_period') ?>

    <?php // echo $form->field($model, 'no_rekening') ?>

    <?php // echo $form->field($model, 'id_employee') ?>

    <?php // echo $form->field($model, 'wt') ?>

    <?php // echo $form->field($model, 'pt') ?>

    <?php // echo $form->field($model, 'jabatan') ?>

    <?php // echo $form->field($model, 'pot_bpjs_kes') ?>

    <?php // echo $form->field($model, 'employee_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
