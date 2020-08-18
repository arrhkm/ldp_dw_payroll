<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cardlogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cardlog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cardlog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pin',
            'id_attmachine',
            //'id_employee',
            [
                'attribute'=>'reg_number',
                'value'=>'employee.reg_number',
            ],
            [
                'attribute'=>'employee_name',
                'value'=>'employee.coreperson.name',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
