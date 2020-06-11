<?php


use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ListEmployee;

$emp = New ListEmployee();

/* @var $this yii\web\View */
/* @var $model app\models\ChildForeman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="child-foreman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'foreman_id')->widget(Select2::className(),[
        'data'=>$emp->getForeman(),
    ]) ?>

    <?= $form->field($model, 'employee_emp_id')->widget(Select2::className(),[
        'data'=>$emp->getNotEmpRegisteredChildForeman(),
    ])?>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
