<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Insentif */

$this->title = 'Create Insentif';
//$this->params['breadcrumbs'][] = ['label' => 'Insentifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insentif-create">

    <h1><?php //= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp_list'=>$emp_list,
        'master_insentif'=>$master_insentif,
    ]) ?>

</div>
