<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kasbon */

$this->title = 'Create Kasbon';
$this->params['breadcrumbs'][] = ['label' => 'Kasbons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kasbon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp'=>$emp,
    ]) ?>

</div>
