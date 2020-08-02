<?php 
use yii\helpers\Html;
use yii\grid\GridView;


echo GridView::widget([
    'dataProvider'=>$provider,
    'filterModel' => $searchModelTimeshiftEmployee,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'date_shift',
        'id_period',
        'id_employee',
        [
            'attribute'=>'employee',
            'value'=>'employee.reg_number', 
        ],
        [
            'attribute'=>'coreperson',
            'value'=>'employee.coreperson.name', 
        ],
        'start_hour', 
        'duration_hour',
        'is_dayoff:boolean',
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{delete}',
            'buttons'=>[
                'delete' => function($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-remove">delete</span>', ['deletetimeshiftemployee', 'id' => $model['id']], ['title' => 'Delete', 'class' => '',]);
                },
                
            ],

        ]
    ]
]);