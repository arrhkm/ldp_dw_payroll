<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ComponentPayroll */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Component Payrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="component-payroll-view">

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
    <?= Html::a('Create Grup', ['componentgroup', 'id_group'=>$model->id], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider'=>$groupProvider,
        'filterModel'=>$groupSearch,
        'columns'=>[
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'id_employee',
            'id_component_payroll',
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',
                'buttons'=>[
                    'delete'=>function($url, $data){
                       
                        return Html::a('Delete', ['componentpayroll/deletegroup', 'id'=>$data->id]);
                    },
                ],
            ],
            
        ],
    ])?>

</div>
