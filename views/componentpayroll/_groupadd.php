<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComponentGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="component-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?php //= $form->field($model, 'id_component_payroll')->textInput() ?>
    <?= $form->field($model, 'start_date')->widget(DatePicker::className(),[
        'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>True,
            'autoclose'=>true,
        ]
    ]) ?>
    <?= $form->field($model, 'end_date')->widget(DatePicker::className(), [
        'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>True,
            'autoclose'=>TRUE,
        ]
    ]) ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$emp,
        'options'=>[
            'multiple'=>true,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
/*
$data=[];
foreach ($emp as $key=>$value){
    echo "key :".$key. "value :".$value."<br>";
    
    if (in_array($key, $group)){
        
    }else {
        array_push($data, 
            $key,$value
        );
    }    
    
}
foreach ($group as $x){
    echo $x."<br>";
}
*/
//var_dump($emp);
