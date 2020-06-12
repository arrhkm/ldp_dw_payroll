<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InsentifResiko */

$this->title = 'Create Insentif Resiko';
$this->params['breadcrumbs'][] = ['label' => 'Insentif Resikos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insentif-resiko-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
