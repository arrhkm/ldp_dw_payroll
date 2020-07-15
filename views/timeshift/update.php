<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Timeshift */

$this->title = 'Update Timeshift: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Timeshifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="timeshift-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
