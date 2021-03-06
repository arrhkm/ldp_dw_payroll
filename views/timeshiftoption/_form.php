<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TimeshiftOption */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeshift-option-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'id_timeshift')->widget(Select2::className(),[
        'data'=>$timeShiftList,
    ]) ?>

    <?= $form->field($model, 'id_employee')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
