<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContractTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contract Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Contract Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name_contract',
            'dscription',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
