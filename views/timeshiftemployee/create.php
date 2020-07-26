<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TimeshiftEmployee */

$this->title = 'Create Timeshift Employee';
$this->params['breadcrumbs'][] = ['label' => 'Timeshift Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeshift-employee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
