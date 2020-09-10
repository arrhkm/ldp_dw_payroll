<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BpjsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bpjs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bpjs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bpjs', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Csv', ['importcsv'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute'=>'reg_number',
                'value'=>'employee.reg_number',
            ],
            [
                'attribute'=>'name',
                'value'=>'employee.name',
            ],
            'bpjs_kes',
            'bpjs_tkerja',
            //'id_employee',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
