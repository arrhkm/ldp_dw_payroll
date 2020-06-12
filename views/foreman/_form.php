<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\components\ListEmployee;


$emp = New ListEmployee();


/* @var $this yii\web\View */
/* @var $model app\models\Foreman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="foreman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'leader_id')->widget(Select2::className(),[
        'data'=>$emp->getNotEmpRegisteredforeman(),
    ]) ?>

    <?= $form->field($model, 'foreman_name')->textInput(['maxlength' => true])?>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
