<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Spkl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spkl-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_spkl')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'todayHighlight'=>TRUE,
            'autoclose'=>TRUE,
            'format'=>'yyyy-mm-dd',
        ]
    ]) ?>

    <?= $form->field($model, 'overtime_hour')->textInput() ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$emp_list,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
