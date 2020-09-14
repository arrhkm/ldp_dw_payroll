<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollLogicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Logics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-logic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Payroll Logic', ['create'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
