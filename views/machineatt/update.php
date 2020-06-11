<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MachineAtt */

$this->title = 'Update Machine Att: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Machine Atts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="machine-att-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
