<?php


use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Timeshift */
/* @var $form yii\widgets\ActiveForm */
?>

<div>
    <p>
    <a class="btn btn-success" id=btnAdd>Add Employee</a>
    </p>
</div>

<?=GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel' => $searchModel,
    'id'=>'grid',
    'columns'=>[
        ['class' => 'yii\grid\SerialColumn'],
        [   
            'class'=> 'yii\grid\CheckboxColumn',
            'checkboxOptions'=>function($data){
                return ['value'=>$data->id];
            },
            //'options' => ['class'=> 'delete' , 'style' =>'background-color: #ff0000;'],
        ],
        'id',
        'id_employee',
        'employee.reg_number',
        [
            'attribute'=>'employee',
            'value'=>'employee.name',
        ],
        [
            'attribute'=>'group',
            'value'=>'payrollGroup.name',
        ],
        //'id_payroll_group',
        //'payrollGroup.name',
    ],
])?>


<?php 

$urlAdd = Url::to(['addtimeshiftemployee']);

$js=<<<js

$('#btnAdd').on('click', function(){
        var selected_row = $('#grid').yiiGridView('getSelectedRows');
        //alert('data :' +selected_row);
        var id_timeshift = "{$id_timeshift}";
        var r = confirm("data ditambah adalah id_timeshift :" +id_timeshift+ "items :"+ selected_row +"Press a button!");
        
        if (r == true){
        $.ajax({
            url     : "{$urlAdd}",
            type    : "POST", 
            data    : {
                item :selected_row,
                id_timeshift : id_timeshift
            }

        });
    }
});
 
js;
$this->registerJs($js);