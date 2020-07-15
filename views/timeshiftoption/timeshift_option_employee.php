<?php

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model app\models\TimeshiftOption */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeshift-option-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_employee')->widget(Select2::className(),[
        'data'=>$data_employee,
        'options' => [
            'placeholder' => 'Select a Employee ...',
            'multiple' => true,
        ],
        'pluginOptions'=>[
            'showToggleAll'=>True,

        ],
    ]) ?>

    <?= $form->field($model, 'id_timeshift')->widget(Select2::className(),[
        'data'=>$timeshift_list,
        'options' => [
            'placeholder' => 'Choice a Timeshift ...',
            'multiple' => false,
        ],
        'pluginOptions'=>[
            'showToggleAll'=>True,

        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$ids = [];
//var_dump($model);
if ($model->id_employee) {
    echo "Timeshift => ".$model->id_timeshift."<br>";
    echo "Employee : <br>";

    foreach ($model->id_employee as $id_emp) {
        array_push($ids, $id_emp);
        
        echo $id_emp. "# ";

    }
}

if (isset($timeshiftOptionProvider)){
    echo GridView::widget([
        'dataProvider' => $timeshiftOptionProvider,
        'columns' => [
            'id',
            'id_employee',
            'employee.coreperson.name',
            'id_timeshift',
            'timeshift.name',
        ],
    ]);
}