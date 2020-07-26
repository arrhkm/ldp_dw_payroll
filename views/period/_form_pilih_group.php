<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_payroll_group')->widget(Select2::className(),[
        'data'=>$group_list,
    ]) ?>

    

    <div class="form-group">
        <?= Html::submitButton('Proses', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
if (isset($model->id_payroll_group)){
    //var_dump($group->payrollGroupEmployee->employee->reg_number);
    $provider1 = New ArrayDataProvider([
        'allModels'=>$payroll_group_employee,
        
    ]);

    echo GridView::widget([
        'dataProvider'=>$provider1,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'id_employee', 
            'employee.reg_number',
            'employee.coreperson.name',
            'employee.basic_salary',
            'employee.date_of_hired',
            'id_payroll_group'
        ]
    ]);
    
    echo GridView::widget([
        'dataProvider'=>$providerTest,
    ]);
}


