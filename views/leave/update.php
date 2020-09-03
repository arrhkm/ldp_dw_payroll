<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Leave */

$this->title = 'Update Leave: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Leaves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="leave-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type_list'=>$type_list,
        'emp_list'=>$emp_list,
    ]) ?>

</div>
