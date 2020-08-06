<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetilKasbonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detil-kasbon-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nilai_cicilan') ?>

    <?= $form->field($model, 'tgl_cicilan') ?>

    <?= $form->field($model, 'id_employee') ?>

    <?= $form->field($model, 'id_kasbon') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
