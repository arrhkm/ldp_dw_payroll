<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payrolls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Payroll', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'reg_number',
            'payroll_name',
            'tg_all',
            't_msker',
            //'i_um',
            //'i_tidak_tetap',
            //'cicilan_kasbon',
            //'pot_safety',
            //'pengurangan',
            //'penambahan',
            'id_payroll_group',
            'id_period',
            //'no_rekening',
            //'id_employee',
            //'wt',
            //'pt',
            //'jabatan',
            //'pot_bpjs_kes',
            //'employee_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
