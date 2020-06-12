<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kartu */

$this->title = $model->no_kartu;
$this->params['breadcrumbs'][] = ['label' => 'Kartus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kartu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'no_kartu' => $model->no_kartu, 'emp_number_kartu' => $model->emp_number_kartu], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'no_kartu' => $model->no_kartu, 'emp_number_kartu' => $model->emp_number_kartu], [
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
            'no_kartu',
            'emp_number_kartu',
            'staff_dw',
            'lokasi',
        ],
    ]) ?>

</div>
