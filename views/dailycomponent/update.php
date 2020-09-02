<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DailyComponent */

$this->title = 'Update Daily Component: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Daily Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="daily-component-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
