<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SakitLama */

$this->title = 'Create Sakit Lama';
$this->params['breadcrumbs'][] = ['label' => 'Sakit Lamas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sakit-lama-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_employee'=>$list_employee,
    ]) ?>

</div>
