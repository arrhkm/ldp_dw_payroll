<?php

use app\models\JenisTunjangan;
use yii\helpers\Html;
use yii\grid\GridView;

use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TunjanganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tunjangans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tunjangan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tunjangan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'One',
                'content' => 'Anim pariatur cliche...',
                'active' => true
            ],
            [
                'label' => 'Two',
                'content' => 'Anim pariatur cliche...',
                'headerOptions' => [],
                'options' => ['id' => 'myveryownID'],
            ],
            [
                'label' => 'Example',
                'url' => 'http://www.example.com',
            ],
            [
                'label' => 'Dropdown',
                'items' => [
                     [
                         'label' => 'DropdownA',
                         'content' => 'DropdownA, Anim pariatur cliche...',
                     ],
                     [
                         'label' => 'DropdownB',
                         'content' => 'DropdownB, Anim pariatur cliche...',
                     ],
                     [
                         'label' => 'External Link',
                         'url' => 'http://www.example.com',
                     ],
                ],
            ],
        ],
    ]);

    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'employee',
                'value'=>'employee.emp_name',
            ],
            'tanggal',
            
            'employee_emp_id',
            //'jenis_tunjangan_id',
            [
                
                'attribute'=>'jenis_tunjangan_id',
                'filter'=>ArrayHelper::map(JenisTunjangan::find()->asArray()->all(), 'id', 'nama_jenis'),
            
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
