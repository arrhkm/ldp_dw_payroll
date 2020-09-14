<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SakitLama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sakit-lama-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'start_sakit')->widget(DatePicker::className(),[
        'options' => ['placeholder' => 'Select a Employee ...'],
        'pluginOptions'=>[
            'todayHighlight'=>TRUE,
            'autoclose'=>TRUE,
            'format'=>'yyyy-mm-dd',
        ]
    ]) ?>

    <?= $form->field($model, 'dscription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_close')->checkbox() ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$list_employee,
        'options' => ['placeholder' => 'Select a Employee ...'],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
