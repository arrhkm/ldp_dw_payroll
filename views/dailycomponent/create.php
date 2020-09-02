<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DailyComponent */

$this->title = 'Create Daily Component';
$this->params['breadcrumbs'][] = ['label' => 'Daily Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daily-component-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
