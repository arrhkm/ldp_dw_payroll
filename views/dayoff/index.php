<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DayoffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dayoffs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dayoff-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dayoff', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_dayoff',
            'dscription',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
