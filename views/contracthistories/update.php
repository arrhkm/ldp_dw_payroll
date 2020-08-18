<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContractHistories */

$this->title = 'Update Contract Histories: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contract Histories', 'url' => ['index', 'id_employee'=>$model->id_employee]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contract-histories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
