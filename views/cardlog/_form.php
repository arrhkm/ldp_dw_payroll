<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cardlog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cardlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'pin')->textInput() ?>

    <?= $form->field($model, 'id_attmachine')->textInput() ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$emp_list,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
