<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlusminGaji */

$this->title = 'Create Plusmin Gaji';
$this->params['breadcrumbs'][] = ['label' => 'Plusmin Gajis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plusmin-gaji-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
