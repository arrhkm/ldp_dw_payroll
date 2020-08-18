<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComponentGroup */

$this->title = 'Update Component Group: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Component Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="component-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
