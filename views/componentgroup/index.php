<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComponentGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Component Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Component Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_component_payroll',
            'id_employee',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
