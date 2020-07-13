<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DownloadMachineForm */
/* @var $form ActiveForm */
?>
<div class="integration">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'start_date')->widget(DatePicker::className(),[
            'pluginOptions'=>[
                'todayHighlight' => true,
                'format'=>'yyyy-mm-dd',
                'todayBtn' => true,
                'autoclose' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'end_date')->widget(DatePicker::className(),[
            'pluginOptions'=>[
                'todayHighlight' => true,
                'format'=>'yyyy-mm-dd',
                'todayBtn' => true,
                'autoclose' => true,
            ],
        ]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Integrasi', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- integration -->

<?php 
if (isset($integrated_log)){
    var_dump($integrated_log);
}
if (isset($emp_array)){
    var_dump($emp_array);
}
