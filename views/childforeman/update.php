<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChildForeman */

$this->title = 'Update Child Foreman: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Child Foremen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="child-foreman-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
