<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PayrollDihitung */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-dihitung-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$list_employee,
        'options' => [
            'placeholder' => 'Select a Employee ...',
            'multiple' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
