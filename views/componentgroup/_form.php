<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComponentGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="component-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'id_component_payroll')->textInput() ?>

    <?= $form->field($model, 'id_employee')->textInput() ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::className(),[
         'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>True,
            'autoclose'=>true,
        ]
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(DatePicker::className(),[
         'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>True,
            'autoclose'=>true,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
