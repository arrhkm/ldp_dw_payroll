<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContractType */

$this->title = 'Create Contract Type';
$this->params['breadcrumbs'][] = ['label' => 'Contract Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
