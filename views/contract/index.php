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
        <?php //= Html::a('Duplicate Contract To Detil', ['duplicate'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
            ],
            'urutan_contract', 
            [
                'attribute'=>'employee_reg_number',
                'label'=>'Reg.', 
                'value'=>'employee.reg_number',
                'contentOptions' => ['style' => 'width:50px; white-space: normal;'],
            ],

            [
                'attribute'=>'employee_name',
                'value'=>'employee.name',
            ],
            [
                'attribute'=>'doh',
                'contentOptions' => ['style' => 'width:100px; white-space: normal;'],
            ],
            [
                'attribute'=>'start_contract',
                'label'=>'Start',
                'contentOptions' => ['style' => 'width:100px; white-space: normal;'],
            ],
            [
                'attribute'=>'duration_contract',
                'label'=>'Duration',
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
            ],
            //'id_contract_type',
            [
                'attribute'=>'contract_type',
                'label'=>'Type',
                'value'=>'contractType.name_contract',
                'contentOptions' => ['style' => 'width:100px; white-space: normal;'],
            ],
            'number_contract',
            'status',
            //'id_employee',
            //'id_department',
            //'id_job_alocation',
            //'id_jobtitle',
            //'id_jobrole',
            //'id_division',            
            //'basic_salary',
            
            'is_active:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update} {delete}',
                'buttons'=>[
                    'addContract'=>function ($url, $model){
                        return Html::a(':: Add Contract', ['/contracthistories/index', 'id_employee'=>$model['id_employee']]);
                    },
                    'delete'=>function($url, $model){
                        $text = '<i class="glyphicon glyphicon-trash"></i>';
                        $url =  ['delete', 'id'=>$model->id];
                        $options = [                        
                            //'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Anda yakin ? hati-hati anda juga akan menghapus semua detil contract item ini!',
                                'method' => 'post',
                            ],
                        ];
                        return Html::a($text, $url, $options);
                    },
                    'perpanjangan'=>function($url, $model){
                        $text = 'Perpanjangan';//'<i class="glyphicon glyphicon-transfer></i>';
                        //$url =  ['delete', 'id'=>$model->id];
                        $url =  ['index', 'id'=>$model->id];
                        $options = [
                            /*'data'=>[
                                'confirm'=>'Anda ingin memperpanjang KONTRAK kerja ?',
                                //'method'=>'post',
                            ],*/
                        ];
                        return Html::a($text, $url, $options);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
