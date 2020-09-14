<?php

use app\models\Payroll;
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\i18n\Formatter;
use kartik\export\ExportMenu;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Salary Period '.$period->period_name.' Group : '.$PayrollGroup->name ;
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label'=>'period', 'url'=>['index','id_period']];
//$this->params['breadcrumbs'][] = ['label'=>'archivepayroll', 'url'=>['archivepayroll','id_period'=>$period->id]];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="period-index">

    <h1><?php //= Html::encode($this->title) ?></h1>

   

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
       
    <?php 
    $dataProvider = New ArrayDataProvider([
       'allModels'=>$data_period,
       'pagination'=>[
          'pageSize'=>20000
       ]
    ]);

    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        'reg_number',
        'employee_name',
        'bank_account',
        'wt',
        'pt',
        //'salary_period_total',
        [
            'label'=>'salary_period_total',
            'contentOptions'=>['style'=>'width: 10%;text-align:right'],
            'value'=>function($model){
               return $model['salary_period_total'];
            },
            
        ],
        
    ];

    // Renders a export dropdown menu
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);

    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showFooter'=>TRUE,
        'columns' => $gridColumns
    ]);
   
   $total =0;
   foreach ($data_period as $dt){
      $total = $total + $dt['salary_period_total'];
   }
   ?>
   <table class="table">
      <tr>
         <td colspan="6">Total</td>
         <td><?=$total?></td>
      </tr>
   </table>