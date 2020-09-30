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

    <?= $form->field($model, 'id')->textInput(['disabled'=>true]) ?>

    <?=$form->field($model, 'urutan_contract')->textInput(['disabled'=>TRUE])?>

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
        'data'=>EmployeeList::getEmployeeisNotContract(),//getEmployeeActive(),
    ]) ?>

    <?php //= $form->field($model, 'id_department')->textInput() ?>

    <?php //= $form->field($model, 'id_job_alocation')->textInput() ?>

    <?php //= $form->field($model, 'id_jobtitle')->textInput() ?>

    <?php //= $form->field($model, 'id_jobrole')->textInput() ?>

    <?php //= $form->field($model, 'id_division')->textInput() ?>

    <?= $form->field($model, 'number_contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_salary')->textInput() ?>

    <?= $form->field($model, 'doh')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'todayHighlight'=>TRUE,
            'format'=>'yyyy-mm-dd',
            'todayBtn'=>true,
            'autoclose'=>True,

        ]
    ]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
