<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JenisTunjanganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jenis Tunjangans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-tunjangan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jenis Tunjangan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nama_jenis',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
