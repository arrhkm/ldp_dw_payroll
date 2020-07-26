<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Leave */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_leave')->widget(DatePicker::class,[
        'pluginOptions'=>[
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format'=>'yyyy-mm-dd',
            
        ]
    ]) ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$emp_list,
    ]) ?>

    <?= $form->field($model, 'id_leave_type')->widget(Select2::className(),[
        'data'=>$type_list,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
