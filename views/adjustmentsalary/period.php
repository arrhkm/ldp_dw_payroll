<?php

use app\models\Period;
use kartik\base\Widget;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdjustmentSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adjustment Salaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-salary-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Adjustment Salary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'end_date',
            
            [
               'class' => 'yii\grid\ActionColumn',
               'template'=>'{period-adjustment}',
               'buttons'=>[
                  'period-adjustment'=>function($url, $model){
                     return Html::a('Period Adjustment', ['period-adjustment','period_id'=>$model->id],['class'=>'btn btn-success']);
                  },
               ]
            ],
        ],
    ]); ?>


</div>
