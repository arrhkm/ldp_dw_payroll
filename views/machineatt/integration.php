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
                'todayBtn' => true,
                'autoclose'=>true,                
                'format'=>'yyyy-mm-dd',
               
            ],
        ]) ?>
        <?= $form->field($model, 'end_date')->widget(DatePicker::className(),[
            'pluginOptions'=>[
                'autoclose'=>true,
                'todayHighlight' => true,
                'todayBtn' => true,
                'format'=>'yyyy-mm-dd',
                
            ],
        ]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Integrasi', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- integration -->

<?php 
if (isset($integrated_log)){
    //var_dump($integrated_log);
    foreach ($integrated_log as $dtlog){
        echo $dtlog['reg_number']."|".$dtlog['date_att']." | ".$dtlog['punch_in']." s/d".$dtlog['punch_out']."<br>";
    }
}