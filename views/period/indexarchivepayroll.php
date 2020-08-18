<?php

use app\models\Payroll;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salary Period '.$period->period_name.' Group : '.$PayrollGroup->name ;
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label'=>'period', 'url'=>['index','id_period']];
$this->params['breadcrumbs'][] = ['label'=>'archivepayroll', 'url'=>['archivepayroll','id_period'=>$period->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="period-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Period', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showFooter'=>TRUE,
        'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_period',
            //'id_employee',
            'reg_number',
            'employee_name',
            'wt',
            'pt',
            //'cicilan_kasbon:currency',
            'employee.coreperson.bank_account',
            //tg_all:currency',
            [
                'attribute'=>'tg_all',
                'value'=>function($model){
                    return Yii::$app->formatter->asCurrency($model->tg_all,'');
                },
                'footer'=>Yii::$app->formatter->asCurrency(Payroll::getTotal($dataProvider->models,'tg_all'),''),
            ]
            

            
        ],
    ])?>