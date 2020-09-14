<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SakitLama */

$this->title = 'Update Sakit Lama: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sakit Lamas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sakit-lama-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_employee'=>$list_employee,
    ]) ?>

</div>
