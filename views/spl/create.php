<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Spl */

$this->title = 'Create Spl';
$this->params['breadcrumbs'][] = ['label' => 'Spls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spl-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data_so'=>$data_so,
    ]) ?>

</div>
