<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContractHistories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contract-histories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'start_contract')->textInput() ?>

    <?= $form->field($model, 'duration_contract')->textInput() ?>

    <?= $form->field($model, 'id_employee')->textInput() ?>

    <?= $form->field($model, 'number_contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doh')->textInput() ?>

    <?= $form->field($model, 'basic_salary')->textInput() ?>

    <?= $form->field($model, 'set_default')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
