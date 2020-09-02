<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DailyComponentDetil */

$this->title = 'Update Daily Component Detil: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Daily Component Detils', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="daily-component-detil-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
