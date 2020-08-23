<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;


/* @var $this yii\web\View */
/* @var $searchModel app\models\LeaveTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leave Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php /*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'is_limited:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */?>

    <?php 
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'name',
        'is_limited:boolean',
        
        ['class' => 'yii\grid\ActionColumn'],
    ];

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);
    
    // You can choose to render your own GridView separately
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns
    ]);

    ?>


</div>
