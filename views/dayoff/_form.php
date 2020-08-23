<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dayoff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dayoff-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_dayoff')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>true,
        ]
    ]) ?>

    <?= $form->field($model, 'dscription')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
