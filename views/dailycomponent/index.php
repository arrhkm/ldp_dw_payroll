<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DailyComponentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daily Components';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daily-component-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Daily Component', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'component_code',

            [
                'class' => 'yii\grid\ActionColumn',
                //'template'=> '{delete}',
                

            ],
        ],
    ]); ?>


</div>
