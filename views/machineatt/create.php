<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MachineAtt */

$this->title = 'Create Machine Att';
$this->params['breadcrumbs'][] = ['label' => 'Machine Atts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-att-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
