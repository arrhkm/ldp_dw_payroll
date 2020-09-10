<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kasbon */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kasbons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kasbon-view">

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
            'date_kasbon',
            'nilai_kasbon',
            'is_active:boolean',
            'employee.name',
            'dscription',
        ],
    ]) ?>
    <?= Html::a('Add Detil Kasbon', ['/detilkasbon/create', 'id_kasbon' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?=GridView::widget([
        'dataProvider'=>$detilProvider,
        'columns' => [
            'id',
            'tgl_cicilan', 
            'nilai_cicilan', 
            'id_kasbon',
            [
                'class'=> 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons'=>[
                    'update'=>function ($url, $model){
                        return Html::a('update', ['detilkasbon/update/','id'=>$model->id]);
                       
                    },
                    'delete'=>function ($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['detilkasbon/delete/','id'=>$model->id]);
                       
                    }
                ],
            ],
        ],
    ])?>

</div>
