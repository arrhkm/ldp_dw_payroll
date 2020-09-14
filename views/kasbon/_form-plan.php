<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kasbon */
/* @var $form yii\widgets\ActiveForm */

//$this->title = 'Detil Plan Kasbon create: ';
//$this->params['breadcrumbs'][] = ['label' => 'View Plan', 'url' => ['kasbon-plan', 'id'=>$kasbon->id]];
//$this->params['breadcrumbs'][] = 'Create Plan';
?>


<div class="kasbon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date_kasbon_plan')->widget(DatePicker::className(), [
        'pluginOptions'=>[
            'format'=>'yyyy-mm-dd',
            'todayHighlight'=>TRUE,            
            'multidate' => true,
            'multidateSeparator' =>';',


        ]
    ]) ?>

    <?= $form->field($model, 'plan_value')->textInput() ?>

    <?php //= $form->field($model, 'is_close')->checkbox() ?>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
