<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Kasbonsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kasbons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kasbon-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kasbon', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_kasbon',
            'nilai_kasbon',
            'is_active:boolean',
            //'id_employee',
            [
                'attribute'=>'employee',
                'value'=>'employee.name',
            ],
            [
                'label'=>'jlm_cicilan',
                'value'=>function($data){
                    $nilai = $data->detilKasbons;
                    $nilai_kasbon = 0;
                    
                    foreach ($nilai as $dtnil){
                        $nilai_kasbon += $dtnil['nilai_cicilan'];
                    }
                    return Yii::$app->formatter->asCurrency($nilai_kasbon, '');
                                        
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
