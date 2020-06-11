<?php

use Codeception\Lib\Generator\Shared\Classname;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Periode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periode-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_periode')->textInput() ?>

    <?= $form->field($model, 'nama_periode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_awal')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'format' => 'yyyy-mm-dd',
		    'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'tgl_akhir')->widget(DatePicker::className(),[
         'pluginOptions'=>[
            'format' => 'yyyy-mm-dd',
		    'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'potongan_jamsos')->textInput() ?>
    <?= $form->field($model, 'potongan_jamsos')->DropDownList(['0' => 'disabled', '1' => 'enabled']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
