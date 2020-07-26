<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reg_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_bpjstk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_bpjskes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_hired')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_permanent')->checkbox() ?>

    <?= $form->field($model, 'id_jobtitle')->textInput() ?>

    <?= $form->field($model, 'id_division')->textInput() ?>

    <?= $form->field($model, 'id_jobrole')->textInput() ?>

    <?= $form->field($model, 'id_department')->textInput() ?>

    <?= $form->field($model, 'id_coreperson')->widget(Select2::className(),[
        'data'=>$employee_list,
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_location')->textInput() ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'id_job_alocation')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
