<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollGroupEmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Group Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-group-employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Payroll Group Employee', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_employee',
            'id_payroll_group',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
