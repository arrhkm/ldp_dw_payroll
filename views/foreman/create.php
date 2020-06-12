<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Foreman */

$this->title = 'Create Foreman';
$this->params['breadcrumbs'][] = ['label' => 'Foremen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foreman-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
