<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Periods';
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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'period_name',
            'start_date',
            'end_date',
            'pot_jamsos:boolean',
            'is_archive:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {schedule}  {timeshift} {integration}  {payroll}  {removeTimeshift} {archivePayroll} {coba}',
                'buttons'=>[
                    'schedule' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-cloud-download">Schedule</span>', ['schedule', 'id' => $model['id']], ['title' => 'Schedule', 'class' => '',]);
                    },
                    'timeshift' => function($url, $model) {
                        return Html::a('<span class="">Timeshift</span>', ['timeshiftemployee', 'id' => $model['id']], ['title' => 'timeshift', 'class' => '',]);
                    },
                    'integration'=>function($url, $model){
                        return Html::a(':: Integrate', ['integration', 'id'=>$model['id']], ['title'=>'integration', 'class'=>'success',]);
                    },
                    'payroll'=>function($url, $model){
                        return Html::a(':: Payroll', ['pilihgroup', 'id'=>$model['id']]);
                    },
                    'removeTimeshift'=>function($url, $model){
                        return Html::a(':: Remove Timeshift', ['removetimeshift', 'id'=>$model['id']]);
                    },
                    'archivePayroll'=>function($url, $model){
                        return Html::a(':: Archive Payroll', ['archivepayroll', 'id_period'=>$model['id']]);
                    },
                    'coba'=>function($url, $model){
                        return Html::a(':: Coba', ['tes', 'id'=>$model['id']]);
                    }

                ],
        
            ],
        ],
    ]); ?>


</div>
