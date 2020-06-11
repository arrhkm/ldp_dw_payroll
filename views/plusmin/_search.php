<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlusminGajiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plusmin-gaji-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kd_plusmin') ?>

    <?= $form->field($model, 'kd_periode') ?>

    <?= $form->field($model, 'emp_id') ?>

    <?= $form->field($model, 'tgl_plusmin') ?>

    <?= $form->field($model, 'jml_plus') ?>

    <?php // echo $form->field($model, 'jml_min') ?>

    <?php // echo $form->field($model, 'ket') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
