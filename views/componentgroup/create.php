<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComponentGroup */

$this->title = 'Create Component Group';
$this->params['breadcrumbs'][] = ['label' => 'Component Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
