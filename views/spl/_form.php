<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use app\components\ListEmployee;

use kartik\date\DatePicker;
use kartik\select2\Select2;


$Emp = New ListEmployee();

/* @var $this yii\web\View */
/* @var $model app\models\Spl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spl-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'employee_emp_id')->widget(Select2::className(),[
        'data'=>$Emp->getEmpList(),
        'options' => ['placeholder' => 'Select a Employee ...'],
        'pluginOptions' => [            
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'date_spl')->widget(DatePicker::className(),[
        //'name'=>'date_spl',
        //'type' => DatePicker::TYPE_INPUT,
        'options'=>['placeholder'=>'Select Date...'],
        'convertFormat'=>true,
        'pluginOptions'=>[
            'format'=>'php:Y-m-d',
            'todayHighlight'=>true,
            'autoclose' => true,
        ]
    ]) ?>

    <?php /*= $form->field($model, 'start_lembur')->widget(DateTimePicker::className(),[       
        
        'name' => 'datetime_1',
       
        'options' => ['placeholder' => 'Select operating time ...'],
        'convertFormat' => false,
        'pluginOptions' => [           
            //'startDate' => '01-Mar-2014 12:00 AM',
            'todayHighlight' => true,
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]) */?>

    <?php /* = $form->field($model, 'end_lembur')->widget(DateTimePicker::className(),[
         'name' => 'datetime_2',
         'options' => ['placeholder' => 'Select operating time ...'],
         'convertFormat' => false,
         'pluginOptions' => [
            
            //'startDate' => '01-Mar-2014 12:00 AM',
            'todayHighlight' => true,
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]) */?>
    <?php 
    /*
    $so = SalesOrder::find()->where(['is_active'=>1])->all();
    $data_so = ArrayHelper::map($so, 'so_number','so_number');
            */
    ?>
   

    <?php //= $form->field($model, 'nama_pekerjaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'overtime_value')->textInput() ?>

    <?php //= $form->field($model, 'satuan')->textInput(['maxlength' => true]) ?>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
