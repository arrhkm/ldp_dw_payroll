<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChildForeman */

$this->title = 'Create Child Foreman';
$this->params['breadcrumbs'][] = ['label' => 'Child Foremen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="child-foreman-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
