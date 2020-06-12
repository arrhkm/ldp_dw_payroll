<?php

use app\models\Employee;
use app\models\JenisTunjangan;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Tunjangan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tunjangan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'tanggal')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'format' => 'yyyy-mm-dd',
		    'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'employee_emp_id')->widget(Select2::className(),[
        'data'=>ArrayHelper::map(Employee::find()->all(), 'emp_id','emp_name'), 

    ]) ?>

    <?= $form->field($model, 'jenis_tunjangan_id')->widget(Select2::className(),[
        'data'=>ArrayHelper::map(JenisTunjangan::find()->all(),'id','nama_jenis'),
    ]) ?>

   

   

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
