<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kartu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kartu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_kartu')->textInput() ?>

    <?= $form->field($model, 'emp_number_kartu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_dw')->textInput() ?>

    <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
