<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Timeshift */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Timeshifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="timeshift-view">

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
            'dscription',
        ],
    ]) ?>

    <div class="center-block"><p> <h3>Detil Timeshift employee</h3></p></div>
    <?= Html::a('Add Detil', ['adddetil', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    
    <?= GridView::widget([
        'dataProvider'=>$Provider,
        'columns' => [
            //'id',
            'start_hour',
            'duration_hour',
            'num_day',
            'is_dayoff',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons'=>[
                    'delete'=>function ($url, $model, $key){
                        $url = \yii\helpers\Url::to(['timeshift/deletedetil', 'id'=>$model->id]);
                        return Html::a('delete', $url);
                    },
                    'update'=>function ($url, $model, $key){
                        $url = \yii\helpers\Url::to(['timeshift/updatedetil', 'id'=>$model->id]);
                        return Html::a('update', $url);
                    }
                ],
            ],
        ],
    ])?>

</div>
