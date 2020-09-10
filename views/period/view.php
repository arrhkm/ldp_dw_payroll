<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\Period */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Periods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="period-view">

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
            'period_name',
            'start_date',
            'end_date',
            'pot_jamsos:boolean',
            'is_archive:boolean',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider'=>$groupProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',    
            'id_period',      
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{setSchedule} {integration} {payroll} {archive} {posted} {pdf} {summarypdf}',
                'buttons'=>[
                    'payroll'=>function($url, $data){
                        return Html::a(
                            'Show Payroll', 
                            ['tes', 'id'=>$data['id_period'], 'id_payroll_group'=>$data['id']],
                            ['class'=>'btn btn-primary']
                        );
                        
                        //return Html::a('Show payroll', ['tes', 'id' => $data['id_period']], ['class' => 'btn btn-primary']);
                    },
                    'archive'=>function($url, $data){
                        return Html::a(
                            'Archive', 
                            [
                                'posting', 
                                'id' => $data['id_period'], 
                                'id_payroll_group'=>$data['id']
                            ], 
                            ['class' => 'btn btn-success']);
                    },
                    'posted'=>function($url, $data){
                        return Html::a(
                            'sumary_posted', 
                            [
                                'payrollperiod', 
                                'id_period' => $data['id_period'], 
                                'id_payroll_group'=>$data['id']
                            ], 
                            ['class' => 'btn btn-success']);
                    },
                    'pdf'=>function($url, $data){
                        return Html::a(
                            'pdf', 
                            [
                                'payrollpdf', 
                                'id_period' => $data['id_period'], 
                                'id_payroll_group'=>$data['id']
                            ], 
                            ['class' => 'btn btn-success']);
                    },
                    'summarypdf'=>function($url, $data){
                        return Html::a(
                            'sumary-pdf', 
                            [
                                'summarypdf', 
                                'id_period' => $data['id_period'], 
                                'id_payroll_group'=>$data['id']
                            ], 
                            ['class' => 'btn btn-success']);
                    },
                    'setSchedule'=>function($url, $data){
                        return Html::a(
                            'Set Schedule',
                            [
                                'schedule',
                                'id'=>$data['id_period'],
                            ],
                            ['class'=>'btn btn-success']
                        );
                    },
                    'integration'=>function($url, $data){
                        return Html::a(
									'integration',
									[
										'integration',
										'id'=>$data['id_period'],
									],
									['class'=>'btn btn-success']
                        );

                    }
                ]
            ],
        ]
    ])?>

</div>
