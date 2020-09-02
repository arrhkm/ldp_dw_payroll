<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DailyComponent */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Daily Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="daily-component-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
         
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'component_code',
        ],
    ]) ?>
    <p>
    <?= Html::a('[+] Tambah Employee]', ['dailycomponentdetil/create/', 'id_daily_component' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to Add this item?',
                //'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_component',
            'id_employee',
            [
                'attribute'=>'reg_number',
                'value'=>'employee.reg_number',
            ],
            [
                'attribute'=>'employee_name',
                'value'=>'employee.name',
            ],
            'id_daily_component',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{delete} {add}',
                'buttons'=>[
                    'delete'=>function($url, $data){
                        return Html::a('delete', ['/dailycomponent/deletedetil/', 'id'=>$data->id], ['class' => 'btn btn-danger']);
                    },
                    'add'=>function($url, $data){
                        return Html::a('add', ['/dailycomponentdetil/create/', 'id_daily_component'=>$data->id], ['class' => 'btn btn-success']);
                    },                   
                ]
            ],
        ],
    ]); ?>

</div>
