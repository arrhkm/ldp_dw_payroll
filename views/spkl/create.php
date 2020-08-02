<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Spkl */

$this->title = 'Create Spkl';
$this->params['breadcrumbs'][] = ['label' => 'Spkls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spkl-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp_list'=>$emp_list,
    ]) ?>

</div>
