<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SpklSeach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Spkls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spkl-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Spkl', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Spkl', ['importspkl'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_spkl',
            'overtime_hour',
            'id_employee',
            [
                'attribute'=>'employee',
                'value'=>'employee.name'
            ],
            'dscription',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
