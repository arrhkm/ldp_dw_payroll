<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Period */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="period-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?php //= $form->field($model, 'period_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'todayHighlight'=>True,
            'format'=>'yyyy-mm-dd',           
            'todayBtn'=>true,
            'autoclose'=>True,
        ]
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'todayHighlight'=>true,
            'format'=>'yyyy-mm-dd',
            'todayBtn'=>true,
            'autoclose'=>true,
        ]
    ]) ?>

    <?= $form->field($model, 'pot_jamsos')->checkbox() ?>

    <?= $form->field($model, 'is_archive')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
