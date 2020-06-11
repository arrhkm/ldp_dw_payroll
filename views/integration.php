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
            'plaginOptions'=>[
                'format'=>'yyyy-mm-dd',
                'todayHightLight'=>True,
            ]
        ]) ?>
        <?= $form->field($model, 'end_date') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- integration -->
