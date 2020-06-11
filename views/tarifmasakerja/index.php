<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchTarifTunjanganMasakerja */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tarif Tunjangan Masakerjas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarif-tunjangan-masakerja-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tarif Tunjangan Masakerja', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'masa_kerja',
            'nilai_tunjangan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
