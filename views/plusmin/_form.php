<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlusminGaji */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plusmin-gaji-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_plusmin')->textInput() ?>

    <?= $form->field($model, 'kd_periode')->textInput() ?>

    <?= $form->field($model, 'emp_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_plusmin')->textInput() ?>

    <?= $form->field($model, 'jml_plus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jml_min')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ket')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
