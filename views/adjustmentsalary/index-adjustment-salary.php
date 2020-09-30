<?php

use app\models\Period;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Adjustment Salary';
$this->params['breadcrumbs'][] = ['label' => 'Period', 'url' => ['period','period_id'=>$period->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<p>
   <?= Html::a('[+]', ['create', 'period_id'=>$period->id], ['class' => 'btn btn-success']) ?>
   <?= Html::a('Import CSV', ['import', 'id_period'=>$period->id], ['class' => 'btn btn-success']) ?>
</p>

<?php
echo GridView::widget([
   'dataProvider' => $dataProvider,
   'filterModel' => $searchModel,
   'id'=>'grid',
   'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [
         'class'=>'yii\grid\CheckboxColumn',

      ],
      'id',
      'date_adjustment',
      'value_adjustment:currency',
      'code_adjustment',
      'id_employee',
      [
         'label'=>'employee',
         'value'=>'employee.coreperson.name',
      ],
      'description',
      //'id_employee',

      [
         'class' => 'yii\grid\ActionColumn',
         'template'=>'{delete}',
         'buttons'=>[
            'delete'=>function($url, $model){
               $period = Period::findOne(['end_date'=>$model->date_adjustment]);
               return Html::a('Delete', ['delete', 'id'=>$model->id, 'period_id'=>$period->id], ['class'=>'btn btn-danger']);
            }
         ]
      ],
      ],
   ]);
    