<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PayrollDihitung */

$this->title = 'Create Payroll Dihitung';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Dihitungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-dihitung-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_employee'=>$list_employee,
    ]) ?>

</div>
