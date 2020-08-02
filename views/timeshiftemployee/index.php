<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TimeshiftEmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Timeshift Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeshift-employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Timeshift Employee', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'date_shift',
            'id_period',
            //'id_employee',
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
            //'is_dayoff:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
