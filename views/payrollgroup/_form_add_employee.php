<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PayrollGroupEmployee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-group-employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>   

    <?= $form->field($model, 'id_payroll_group')->textInput() ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$employee_list,
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
