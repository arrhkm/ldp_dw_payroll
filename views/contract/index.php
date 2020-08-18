<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContractSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contracts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Contract', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'employee_reg_number',
                'value'=>'employee.reg_number',
            ],
            [
                'attribute'=>'employee_name',
                'value'=>'employee.name',
            ],
            'start_contract',
            'duration_contract',
            //'id_contract_type',
            [
                'attribute'=>'contract_type',
                'value'=>'contractType.name_contract',
            ],
            'id_employee',
            //'id_department',
            //'id_job_alocation',
            //'id_jobtitle',
            //'id_jobrole',
            //'id_division',
            'number_contract',
            'basic_salary',
            'doh',
            'is_active:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update} {delete} {addContract}',
                'buttons'=>[
                    'addContract'=>function ($url, $model){
                        return Html::a(':: Add Contract', ['/contracthistories/index', 'id_employee'=>$model['id_employee']]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
