<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TimeshiftOptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Timeshift Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeshift-option-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Timeshift Option', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Timeshift Employee', ['timeshiftoptionemployee'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_timeshift',
            'timeshift.name',
            'id_employee',
            'employee.reg_number',
            'employee.coreperson.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
