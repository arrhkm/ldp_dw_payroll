<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kasbon */

$this->title = 'Update Kasbon: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kasbons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kasbon-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp'=>$emp,
    ])?>
</div>
