<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttmachineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attmachines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attmachine-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Attmachine', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Attendance', ['importattendance'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'ip',
            'com_key',
            'port',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'buttons'=>[
                    'delete' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-cloud-download">Download</span>', ['download', 'id' => $model['id']], ['title' => 'Download', 'class' => '',]);
                    }
                    
                ],
            ],
        ],
    ]); ?>


</div>
