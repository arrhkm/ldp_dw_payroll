<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalesOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'so_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dscription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->checkBox(['label' => 'is active?', 
'uncheck' => '0', 'checked' => '1']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
