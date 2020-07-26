<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Insentif */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insentif-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_insentif')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'todayHighlight'=>TRUE,
            'format'=>'yyyy-mm-dd',
            'autoclose'=>true,
            
        ]
    ]) ?>


    <?= $form->field($model, 'id_insentif_master')->widget(Select2::class,[
        'data'=>$master_insentif,
    ]) ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$emp_list,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
