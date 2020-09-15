<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Log */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
       'data'=>$list_employee,
    ]) ?>

    <?= $form->field($model, 'date_log')->widget(DatePicker::className(),[
       'pluginOptions'=>[
         'todayHighlight'=>True,
         'format'=>'yyyy-mm-dd',           
         'todayBtn'=>true,
         'autoclose'=>True,
     ]
    ]);?>
    <?= $form->field($model, 'time_log')->widget(TimePicker::className(),[
       'pluginOptions' => [
         'showSeconds' => true,
         'showMeridian' => false,
         'minuteStep' => 1,
         'secondStep' => 5,
     ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
if(isset($pin)){
   echo "PIN :".$pin." - ".$dt_timestamp;
}