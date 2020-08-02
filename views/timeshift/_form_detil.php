<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;

//use yii\redactor\widgets\Redactor;
/*
 * @property int $id_outservice
 * @property int $id_employee
 * @property string $date_detil_outservice
 * @property int $id
 * 
 */
$num_day = [
    
    1=>'Monday-Senin',
    2=>'Tuesday-Selasa', 
    3=>'Wednesday-Rabu', 
    4=>'Thursday-Kamis', 
    5=>'Friday-Jumat', 
    6=>'Saturday-Sabtu',
    7=>'Sunday-Minggu',
];

?>

<div class="outservice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($modelDetil, 'id')->textInput() ?>

    <?= $form->field($modelDetil, 'start_hour')->widget(TimePicker::className(),[
        'pluginOptions'=>[
            'defaultTime'=>'08:00:00',
            //'current'=>'08:00:00',
            'showSeconds'=>True,
            'showMeridian'=>false,
        ]
    ])?>
 
    <?= $form->field($modelDetil, 'duration_hour')->textInput() ?>

    <?= $form->field($modelDetil, 'num_day')->widget(Select2::className(),[
        'data'=>$num_day,
    ]) ?>

    <?= $form->field($modelDetil, 'is_dayoff')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
