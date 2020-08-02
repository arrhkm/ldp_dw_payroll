<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InsentifSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insentifs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insentif-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Insentif', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_insentif',
            'id_insentif_master',
            'id_employee',
            [
                'attribute'=>'reg_number',
                'value'=>'employee.reg_number',
            ],
            [
                'attribute'=>'employee_name',
                'value'=>'employee.name',
            ],
            [
                'attribute'=>'insentif',
                'value'=>'insentifMaster.name',
            ],
            'insentifMaster.value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
