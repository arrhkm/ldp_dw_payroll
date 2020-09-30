<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdjustmentSalary */

$this->title = 'Update Adjustment Salary: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Adjustment Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="adjustment-salary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
