<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TimeshiftSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Timeshifts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeshift-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Timeshift', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'dscription',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {anggota}',
                'buttons'=>[
                    'anggota'=>function($url, $model){
                        $text='anggota';
                        $url = ['anggota', 'id_timeshift'=>$model->id];
                        $options = ['class'=>'btn btn-success'];
                        return Html::a($text, $url, $options);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
