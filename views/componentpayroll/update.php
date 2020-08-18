<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComponentPayroll */

$this->title = 'Update Component Payroll: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Component Payrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="component-payroll-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
