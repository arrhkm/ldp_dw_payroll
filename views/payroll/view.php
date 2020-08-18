<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payroll-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'reg_number',
            'payroll_name',
            'tg_all',
            't_msker',
            'i_um',
            'i_tidak_tetap',
            'cicilan_kasbon',
            'pot_safety',
            'pengurangan',
            'penambahan',
            'id_payroll_group',
            'id_period',
            'no_rekening',
            'id_employee',
            'wt',
            'pt',
            'jabatan',
            'pot_bpjs_kes',
            'employee_name',
        ],
    ]) ?>

</div>
