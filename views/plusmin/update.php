<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlusminGaji */

$this->title = 'Update Plusmin Gaji: ' . $model->kd_plusmin;
$this->params['breadcrumbs'][] = ['label' => 'Plusmin Gajis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kd_plusmin, 'url' => ['view', 'id' => $model->kd_plusmin]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plusmin-gaji-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
