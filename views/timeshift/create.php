<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Timeshift */

$this->title = 'Create Timeshift';
$this->params['breadcrumbs'][] = ['label' => 'Timeshifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeshift-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
