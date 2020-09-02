<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TimeshiftOption */

$this->title = 'Create Timeshift Option';
$this->params['breadcrumbs'][] = ['label' => 'Timeshift Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeshift-option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'timeShiftList'=>$timeShiftList,
    ]) ?>

</div>
