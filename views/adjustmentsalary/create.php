<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdjustmentSalary */

$this->title = 'Create Adjustment Salary';
$this->params['breadcrumbs'][] = ['label' => 'Period Adjustment Salaries', 'url' => ['period-adjustment','period_id'=>$model->period_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-salary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-add', [
        'model' => $model,
        'list_code'=>$list_code,
        'employee'=>$employee,
    ]) ?>

</div>
