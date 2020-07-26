<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InsentifMaster */

$this->title = 'Create Insentif Master';
$this->params['breadcrumbs'][] = ['label' => 'Insentif Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insentif-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
