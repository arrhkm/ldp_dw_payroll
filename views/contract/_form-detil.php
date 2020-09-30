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
$this->title = 'Perpanjangan Contract';
$sub_title= $model->contract->employee->coreperson->name." - REG : {$model->contract->employee->reg_number}";
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $sub_title, 'url' => ['view', 'id'=>$model->id_contract]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="contract-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['disabled'=>true]) ?>
    
    <?= $form->field($model, 'urutan_contract')->textInput(['disabled'=>true, 'id'=>'urutan'])?>
    <div id="cek">Coba</div>

    <?= $form->field($model, 'start_contract')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'todayHighlight'=>True,
            'format'=>'yyyy-mm-dd',            
            'autoclose' => true,
            'todayBtn'=>true,
        ]
    ])?>

   <?= $form->field($model, 'duration_contract')->textInput(['id'=>'duration', 'onchange(this.value()']) ?>

   <?= $form->field($model, 'number_contract')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'end_contract')->textInput() ?>

   <?= $form->field($model, 'status_execute')->textInput() ?>

   <?php /*= $form->field($model, 'id_employee')->widget(Select2::className(),[
      'data'=>EmployeeList::getEmployee(),
   ]) */?>

   

   

   <div class="form-group">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>

<?php 

$js= <<<js


$(document).ready(function(){
    var urutan = $('#urutan').val();
    $('#cek').click(function(){
        alert("data :"+urutan);
    });
    
    $('#duration).onchange(function(){
        
        alert('Duration :');

    });


    


});

js;
$this->registerJs($js);