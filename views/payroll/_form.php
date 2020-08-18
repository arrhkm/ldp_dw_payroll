<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'reg_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payroll_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tg_all')->textInput() ?>

    <?= $form->field($model, 't_msker')->textInput() ?>

    <?= $form->field($model, 'i_um')->textInput() ?>

    <?= $form->field($model, 'i_tidak_tetap')->textInput() ?>

    <?= $form->field($model, 'cicilan_kasbon')->textInput() ?>

    <?= $form->field($model, 'pot_safety')->textInput() ?>

    <?= $form->field($model, 'pengurangan')->textInput() ?>

    <?= $form->field($model, 'penambahan')->textInput() ?>

    <?= $form->field($model, 'id_payroll_group')->textInput() ?>

    <?= $form->field($model, 'id_period')->textInput() ?>

    <?= $form->field($model, 'no_rekening')->textInput() ?>

    <?= $form->field($model, 'id_employee')->textInput() ?>

    <?= $form->field($model, 'wt')->textInput() ?>

    <?= $form->field($model, 'pt')->textInput() ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pot_bpjs_kes')->textInput() ?>

    <?= $form->field($model, 'employee_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
