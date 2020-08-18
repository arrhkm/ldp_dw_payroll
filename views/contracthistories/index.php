<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContractHistoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contract Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-histories-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Contract Histories', ['create','id_employee'=>$employee->id], ['class' => 'btn btn-success']) ?>
    </p>
    <table class="table">
        <tr>
            <td>REG NUMBER</td>
            <td><?=$employee->reg_number?></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><?=$employee->name?></td>
        </tr>
        <tr>
            <td>D O H</td>
            <td><?=$employee->date_of_hired?></td>
        </tr>
        <tr>
            <td>Basic Salary</td>
            <td><?=$employee->basic_salary?></td>
        </tr>
    </table>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'start_contract',
            'duration_contract',
            'id_employee',
            'number_contract',
            'doh',
            'basic_salary',
            'set_default:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
