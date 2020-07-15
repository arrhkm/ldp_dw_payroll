<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Periods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="period-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Period', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'period_name',
            'start_date',
            'end_date',
            'pot_jamsos:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {schedule}',
                'buttons'=>[
                    'schedule' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-cloud-download">Schedule</span>', ['schedule', 'id' => $model['id']], ['title' => 'Schedule', 'class' => '',]);
                    }
                    
                ],
        
            ],
        ],
    ]); ?>


</div>
