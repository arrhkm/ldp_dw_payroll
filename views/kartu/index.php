<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KartuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kartus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kartu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kartu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_kartu',
            'emp_number_kartu',
            'staff_dw',
            'lokasi',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
