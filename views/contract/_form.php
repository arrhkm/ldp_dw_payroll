<?php

use app\components\CppContractType;
use app\components\CppCpntractType;
use app\components\EmployeeList;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contract */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contract-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'start_contract')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'todayHighlight'=>True,
            'format'=>'yyyy-mm-dd',
            
            'autoclose' => true,
            'todayBtn'=>true,
            
        ]
    ]) ?>

    <?= $form->field($model, 'duration_contract')->textInput() ?>

    <?= $form->field($model, 'id_contract_type')->widget(Select2::className(),[
        'data'=>CppContractType::getType(),
    ]) ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>EmployeeList::getEmployee(),
    ]) ?>

    <?= $form->field($model, 'id_department')->textInput() ?>

    <?= $form->field($model, 'id_job_alocation')->textInput() ?>

    <?= $form->field($model, 'id_jobtitle')->textInput() ?>

    <?= $form->field($model, 'id_jobrole')->textInput() ?>

    <?= $form->field($model, 'id_division')->textInput() ?>

    <?= $form->field($model, 'number_contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_salary')->textInput() ?>

    <?= $form->field($model, 'doh')->textInput() ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
