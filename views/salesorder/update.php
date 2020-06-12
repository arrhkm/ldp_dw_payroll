<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesOrder */

$this->title = 'Update Sales Order: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sales Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
