<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bpjs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bpjs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'bpjs_kes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bpjs_tkerja')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_employee')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
