<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DailyComponentDetil */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="daily-component-detil-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_component')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>true,

        ],
    ]) ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$employee_list,
    ]) ?>

    <?php //= $form->field($model, 'id_daily_component')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['dailycomponent/view', 'id'=>$model->id_daily_component],['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
