<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KartuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kartu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_kartu') ?>

    <?= $form->field($model, 'emp_number_kartu') ?>

    <?= $form->field($model, 'staff_dw') ?>

    <?= $form->field($model, 'lokasi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
