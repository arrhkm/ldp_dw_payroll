<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Insentif */

$this->title = 'Update Insentif: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insentifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="insentif-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp_list'=>$emp_list,
        'master_insentif'=>$master_insentif,
    ]) ?>

</div>
