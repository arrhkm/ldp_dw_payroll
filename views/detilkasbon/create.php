<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DetilKasbon */

$this->title = 'Create Detil Kasbon';
//$this->params['breadcrumbs'][] = ['label' => 'Detil Kasbons', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label'=>"Kasbon".$model->id, 'url'=>['kasbon/view', 'id'=>$model->id_kasbon]];
?>
<div class="detil-kasbon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
