<?php

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdjustmentSalary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adjustment-salary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?=$form->field($model, 'date_adjustment')->textInput() ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$employee,
        'options' => ['placeholder' => 'Select  ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
    ]) ?>

    <?= $form->field($model, 'code_adjustment')->widget(Select2::className(),[
        'data'=>$list_code,
    ]) ?>


    <?=$form->field($model, 'value_adjustment')->textInput() ?>

   
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php  ActiveForm::end(); ?>

</div>



