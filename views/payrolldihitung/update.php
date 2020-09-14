<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PayrollDihitung */

$this->title = 'Update Payroll Dihitung: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Dihitungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-dihitung-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_employee'=>$list_employee,
    ]) ?>

</div>
