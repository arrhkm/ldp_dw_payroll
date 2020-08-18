<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContractHistories */

$this->title = 'Create Contract Histories';
$this->params['breadcrumbs'][] = ['label' => 'Contract Histories', 'url' => ['index', 'id_employee'=>$employee->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-histories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'employee'=>$employee,
    ]) ?>

</div>
