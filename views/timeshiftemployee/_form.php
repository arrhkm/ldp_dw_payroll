<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TimeshiftEmployee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeshift-employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_shift')->textInput() ?>

    <?= $form->field($model, 'id_period')->textInput() ?>

    <?= $form->field($model, 'id_employee')->textInput() ?>

    <?= $form->field($model, 'start_hour')->textInput() ?>

    <?= $form->field($model, 'duration_hour')->textInput() ?>

    <?= $form->field($model, 'is_dayoff')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
