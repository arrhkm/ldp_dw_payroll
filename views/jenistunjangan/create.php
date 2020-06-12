<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JenisTunjangan */

$this->title = 'Create Jenis Tunjangan';
$this->params['breadcrumbs'][] = ['label' => 'Jenis Tunjangans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-tunjangan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
