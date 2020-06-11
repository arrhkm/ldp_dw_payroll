<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InsentifResikoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insentif Resiko';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insentif-resiko-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Insentif Resiko', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import File Insentif Resiko', ['iresiko/import'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'value',
            'date_insentif',
            'dscription',
            'employee_emp_id',
            [
                'attribute'=>'employee',
                'value'=>'employee.emp_name',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
