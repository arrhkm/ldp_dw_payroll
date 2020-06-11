<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_rekening')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kd_jabatan')->textInput() ?>

    <?= $form->field($model, 'gaji_pokok')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gaji_lembur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pot_jamsos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 't_jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 't_masakerja')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 't_insentif')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pot_telat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uang_makan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_work')->textInput() ?>

    <?= $form->field($model, 'start_contract')->textInput() ?>

    <?= $form->field($model, 'end_contract')->textInput() ?>

    <?= $form->field($model, 'lama_contract')->textInput() ?>

    <?= $form->field($model, 'emp_group')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
