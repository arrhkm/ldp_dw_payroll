<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DailyComponentDetil */

$this->title = 'Create Daily Component Detil';
$this->params['breadcrumbs'][] = ['label' => 'Daily Component Detils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daily-component-detil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'employee_list'=>$employee_list,
    ]) ?>

</div>
