<?php 
use yii\helpers\Html;
use yii\grid\GridView;


echo GridView::widget([
    'dataProvider'=>$provider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'date_shift',
        'id_period',
        'id_employee',
        'employee.reg_number',
        'employee.coreperson.name', 
        'start_hour', 
        'duration_hour',
        'is_dayoff:boolean',
    ]
]);