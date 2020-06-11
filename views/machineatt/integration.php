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
                'format'=>'yyyy-mm-dd',
                'todayHightLight'=>True,
            ],
        ]) ?>
        <?= $form->field($model, 'end_date')->widget(DatePicker::className(),[
            'pluginOptions'=>[
                'format'=>'yyyy-mm-dd',
                'todayHightLight'=>True,
            ],
        ]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Integrasi', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- integration -->

<?if (isset($integrated_log)){
    var_dump($integrated_log);
}