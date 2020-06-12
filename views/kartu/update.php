<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kartu */

$this->title = 'Update Kartu: ' . $model->no_kartu;
$this->params['breadcrumbs'][] = ['label' => 'Kartus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->no_kartu, 'url' => ['view', 'no_kartu' => $model->no_kartu, 'emp_number_kartu' => $model->emp_number_kartu]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kartu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
