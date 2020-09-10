<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kasbon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kasbon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_kasbon')->widget(DatePicker::className(), [
        'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>TRUE,


        ]
    ]) ?>

    <?= $form->field($model, 'nilai_kasbon')->textInput() ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(), [
        'data'=>$emp,
        
    ]) ?>

    <?= $form->field($model, 'dscription')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
