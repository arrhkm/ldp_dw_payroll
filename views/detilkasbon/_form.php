<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetilKasbon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detil-kasbon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'nilai_cicilan')->textInput() ?>

    <?= $form->field($model, 'tgl_cicilan')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>TRUE,

        ]
    ]) ?>

    <?= $form->field($model, 'id_employee')->textInput() ?>

    <?= $form->field($model, 'id_kasbon')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
