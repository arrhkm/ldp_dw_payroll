<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PayrollGroup */

$this->title = 'Update Payroll Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_logic'=>$list_logic,
    ]) ?>

</div>
