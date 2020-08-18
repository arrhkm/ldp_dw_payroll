<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cardlog */

$this->title = 'Create Cardlog';
$this->params['breadcrumbs'][] = ['label' => 'Cardlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cardlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp_list'=>$emp_list,
    ]) ?>

</div>
