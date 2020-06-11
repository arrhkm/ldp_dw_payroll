<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlusminGajiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plusmin Gajis';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Import CSV', 'url' => ['plusmin/importcsv']];
?>
<div class="plusmin-gaji-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Plusmin Gaji', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kd_plusmin',
            'kd_periode',
            'emp_id',
            'tgl_plusmin',
            'jml_plus',
            //'jml_min',
            //'ket',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
