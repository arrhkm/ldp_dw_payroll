<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contract */

$this->title = $model->employee->coreperson->name." - REG : {$model->employee->reg_number}";
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contract-view">

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
            'start_contract',
            'urutan_contract',
            'end_contract', 
            'duration_contract',
            'id_contract_type',
            'id_employee',
            'id_department',
            'id_job_alocation',
            'id_jobtitle',
            'id_jobrole',
            'id_division',
            'number_contract',
            'basic_salary',
            'doh',
            'is_active:boolean',
        ],
    ]) ?>

</div>
<p><?= Html::a('Perpanjangan', ['perpanjangan', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></p>
<?php

echo GridView::widget([
    'dataProvider'=>$provider,
    'columns'=>[
        'number_contract', 
        'start_contract', 
        'end_contract', 
        'duration_contract', 
        'urutan_contract', 
        'id_contract', 
        'status_execute', 
        [
            'class'=>'yii\grid\ActionColumn',
            'template'=>'{delete} {setDeffault}',
            'buttons'=>[
                'delete'=>function($url, $model){
                    $url=['delete-detil', 'id'=>$model->id, 'id_contract'=>$model->id_contract];
                    $text='remove';
                    $options = ['class'=>'btn btn-danger'];
                    return Html::a($text, $url, $options);
                },
                'setDeffault'=>function($url, $model){
                    $url=['set-deffault', 'id'=>$model->id, 'id_contract'=>$model->id_contract];
                    $text='Set';
                    $options = ['class'=>'btn btn-primary'];
                    return Html::a($text, $url, $options);
                }
            ]
        ]
    ]
]);
