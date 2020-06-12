<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Periode */

$this->title = 'Update Periode: ' . $model->kd_periode;
$this->params['breadcrumbs'][] = ['label' => 'Periodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kd_periode, 'url' => ['view', 'id' => $model->kd_periode]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="periode-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
