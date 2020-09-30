<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InsentifSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insentifs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insentif-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- ?= Html::a('Create Insentif', ['create'], ['class' => 'btn btn-success']) ? -->
        <!-- a class="btn btn-info btnCreate" value="<?= Url::to(['create']) ?>">Create Modal</a -->
        <a class="btn btn-success btnMulti" value="<?= Url::to(['createmultiple']) ?>">Create Insentif With Multiple Date</a>
        <a class="btn btn-danger btnDeleteMultiple">Delete Selected</a>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      
        'filterModel' => $searchModel,
        'id'=>'grid',
        
        'columns' => [
           
            ['class' => 'yii\grid\SerialColumn'],
            [   
                'class'=> 'yii\grid\CheckboxColumn',
                'checkboxOptions'=>function($model){
                    return ['value'=>$model->id];
                },
                //'options' => ['class'=> 'delete' , 'style' =>'background-color: #ff0000;'],
            ],
            'id',
            'date_insentif',
            //'id_insentif_master',
            [
                'attribute'=>'insentif',
                'value'=>'insentifMaster.name',
            ],
            //'id_employee',
            [
                'attribute'=>'reg_number',
                'value'=>'employee.reg_number',
            ],
            [
                'attribute'=>'employee_name',
                'value'=>'employee.name',
            ],
           
            'insentifMaster.value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<?php
/*
    Modal::begin([
        'header' => 'Create Insentif',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    */
?>
<?php
    Modal::begin([
        'header' => 'Create Multi',
        'id' => 'modalMulti',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalMultiContent'></div>";
    Modal::end();
?>

<?php 
$urlDelete = Url::to(['deleteselected']);
$js=<<<js
    
    $('.btnMulti').on('click', function () {       
        if ($('#modalMulti').data('bs.modal').isShown) {
            $('#modalMulti').find('#modalMultiContent')
                    .load($(this).attr('value'));
            //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            //if modal isn't open; open it and load content
            $('#modalMulti').modal('show')
                    .find('#modalMultiContent')
                    .load($(this).attr('value'));
             //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });

    $('.btnCreate').on('click', function () {        
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                    .load($(this).attr('value'));
            //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
             //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });

    $('.btnDeleteMultiple').on('click', function(){
        var selected_row = $('#grid').yiiGridView('getSelectedRows');
        //alert('data :' +selected_row);
        var r = confirm("Delete data :"+ selected_row +"Press a button!");
        if(r==true)
        {
            $.ajax({
                url     : "{$urlDelete}",
                type    : "POST", 
                data    : {item :selected_row}

            });
        }
    });

    
js;
$this->registerJs($js);