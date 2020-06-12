<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use app\components\ListEmployee;

$emp = new ListEmployee();
$emp_list = $emp->getEmpList();


/* @var $this yii\web\View */
/* @var $model app\models\InsentifResiko */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insentif-resiko-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'employee_emp_id')->label('Employee')->widget(Select2::className(), [
        'data'=>$emp_list,
    ]) ?>

    <?= $form->field($model, 'date_insentif')->widget(DatePicker::className(), [
        'dateFormat'=>'php:Y-m-d',
    ])?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dscription')->textInput(['maxlength' => true]) ?>

    

    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
