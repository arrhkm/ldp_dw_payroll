<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Attmachine */

$this->title = 'Create Attmachine';
$this->params['breadcrumbs'][] = ['label' => 'Attmachines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attmachine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
