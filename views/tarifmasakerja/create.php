<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TarifTunjanganMasakerja */

$this->title = 'Create Tarif Tunjangan Masakerja';
$this->params['breadcrumbs'][] = ['label' => 'Tarif Tunjangan Masakerjas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarif-tunjangan-masakerja-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
