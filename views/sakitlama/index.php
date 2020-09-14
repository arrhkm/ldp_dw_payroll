<?php

use app\components\hkm\payroll\CppSakitLama;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SakitLamaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sakit Lamas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sakit-lama-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sakit Lama', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'start_sakit',
            'dscription',
            'is_close:boolean',
            'id_employee',
            [
                'label'=>'Lama Sakit',
                'value'=>function($model){
                    $date_now = date('Y-m-d');
                    $fDate = New CppSakitLama($model->start_sakit, $date_now, 170000);
                    return "Lama:".$fDate->getLamaBulan()." # Basic : ".$fDate->getBasic();
                    //return $date_now;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
