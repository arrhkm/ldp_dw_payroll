<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kartu */

$this->title = 'Create Kartu';
$this->params['breadcrumbs'][] = ['label' => 'Kartus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kartu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
