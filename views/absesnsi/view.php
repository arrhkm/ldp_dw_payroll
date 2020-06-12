<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Absensi */

$this->title = $model->tgl;
$this->params['breadcrumbs'][] = ['label' => 'Absensis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="absensi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tgl' => $model->tgl, 'emp_id' => $model->emp_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tgl' => $model->tgl, 'emp_id' => $model->emp_id], [
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
            'tgl',
            'emp_id',
            'jam_in',
            'jam_out',
            'ket_absen',
            'timestamp_diff:datetime',
            'status',
            'loc_code',
        ],
    ]) ?>

</div>
