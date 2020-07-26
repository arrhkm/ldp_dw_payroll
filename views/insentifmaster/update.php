<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InsentifMaster */

$this->title = 'Update Insentif Master: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Insentif Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="insentif-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
