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
            [
                'attribute'=>'nilai_kasbon',
                'format'=>'currency',
            ],
            'is_active:boolean',
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
            [
                'label'=>'sisa_kasbon',
                'value'=>function($data){
                    $nilai = $data->detilKasbons;
                    $nilai_kasbon = 0;
                    
                    foreach ($nilai as $dtnil){
                        $nilai_kasbon += $dtnil['nilai_cicilan'];
                    }
                    return Yii::$app->formatter->asCurrency($data->nilai_kasbon-$nilai_kasbon,'');
                }
            ],
            'description',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {plan}',
                'buttons'=>[
                    'plan'=>function($url,$model){
                        return Html::a('Plan', ['kasbon-plan', 'id'=>$model->id], ['class'=>'btn btn-primary']);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
