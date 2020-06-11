<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'emp_id',
            'emp_name',
            'no_rekening',
            'kd_jabatan',
            'gaji_pokok',
            //'gaji_lembur',
            //'pot_jamsos',
            //'t_jabatan',
            //'t_masakerja',
            //'t_insentif',
            //'pot_telat',
            //'uang_makan',
            //'start_work',
            //'start_contract',
            //'end_contract',
            //'lama_contract',
            //'emp_group',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
