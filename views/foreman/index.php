<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ForemanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Foremen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foreman-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Foreman', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'foreman_name',
            'leader_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
