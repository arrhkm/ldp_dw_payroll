<?php

use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Absensi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="absensi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_set')->widget(DatePicker::className(),[
        'pluginOptions' => [
            'autoclose'=>true,
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>true,
        ],
    ])?>

    <?= $form->field($model, 'jam_pulang')->widget(TimePicker::className(),[
       
            'name' => 't1',
            'pluginOptions' => [
                'showSeconds' => true,
                'showMeridian' => false,
                'minuteStep' => 1,
                'secondStep' => 5,
            ]
        
    ]) ?>

   
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
if (isset($provider)){
    echo GridView::widget([
        'dataProvider' => $provider,
       
        /*'columns' => [
            
        ],*/
    ]);
}
?>
