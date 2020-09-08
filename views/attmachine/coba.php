<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttmachineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attmachines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attmachine-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Attmachine', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Attendance', ['importattendance'], ['class' => 'btn btn-success']) ?>
        <?= Html::button('Delete Selected', ['class'=>'btn btn-danger', 'id'=>'deleteSelect'])?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',            
                'checkboxOptions' => function($model) {
                    return ['value' => $model->id, 'class' => 'checkbox-row', 'id' =>'hkm_checkbox'];
                }
            ],

            'id',
            'name',
            'ip',
            'com_key',
            'port',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                /*'buttons'=>[
                    'delete' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-cloud-download">Download</span>', ['download', 'id' => $model['id']], ['title' => 'Download', 'class' => '',]);
                    }
                    
                ],*/
            ],
        ],
    ]); ?>


</div>
<?php 


$urlDeleteSelect = Url::toRoute(['attmachine/deleteselect']);
//use richardfan\widget\JSRegister;
//JSRegister::begin();
  
$js=<<<js
$('#deleteSelect').on('click', function(){ 
    
    var container = [];
    $.each($("input[name='selection[]']:checked"), function() {
        container.push($(this).val());
    });

    $.ajax({
        url : "{$urlDeleteSelect}",
        type : "POST",
        data : {            
            emp:container,
        },
        success : function(result){
            console.log(result);
        }
    });
    alert('Hasil nya adalah' +container);
});

js;
$this->registerJs($js);