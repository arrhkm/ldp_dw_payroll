<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChildForemanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Child Foremen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="child-foreman-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Child Foreman', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee_emp_id',
            'employee.emp_name',
            'foreman_id',
            'foreman.leader.emp_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
