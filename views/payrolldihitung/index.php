<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollDihitungSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Dihitungs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-dihitung-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Payroll Dihitung', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::button('Button', ['class'=>'btn btn-danger', 'id'=>'btnSelected'])?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'grid',
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_employee',
            [
                'class'=>'yii\grid\CheckboxColumn',
                'checkboxOptions'=>function($model){
                    return ['value' => $model->id];
                }
            ],
            [
                'attribute'=>'reg_number',
                'value'=>'employee.reg_number',
            ],
            [
                'attribute'=>'employee_name',
                'value'=>'employee.name',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<?php 
$urlSelected = Url::to(['deleteall']);
$js=<<<js
$('#btnSelected').on('click', function(){
    var selected_row = $('#grid').yiiGridView('getSelectedRows');
    alert('data :' +selected_row);
    $.ajax({
        url     : "{$urlSelected}",
        type    : "POST", 
        data    : {item :selected_row}

    });
    
});

js;
$this->registerJs($js);