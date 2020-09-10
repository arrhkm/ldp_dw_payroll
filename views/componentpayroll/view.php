<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use richardfan\widget\JSRegister;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\ComponentPayroll */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Component Payrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="component-payroll-view">

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
            'name',
            'component_code',
        ],
    ])?>
    <p id="demo"></p>
    
    <?= Html::a('Create Grup', ['componentgroup', 'id_group'=>$model->id], ['class' => 'btn btn-success']) ?>
    
    <div class="form-group pull-right">
        <?php /* = Html::submitButton(
            'Set Update', 
            [
                'class' => 'btn btn-primary',
                'id'=>'myButton',
            ]) 
        */?>
    </div>
    <?= Html::button('Update Selected', ['class'=>'btn btn-success', ])?>
    <?= Html::button('Delete Selected', ['class'=>'btn btn-danger', 'id'=>'deleteSelect'])?>
    <?php // Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider'=>$groupProvider,
        'filterModel'=>$groupSearch,
        'id' => 'grid',
        'columns'=>[
            //['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' =>function($model) {
                    return ['value' => $model->id, 'class' => 'checkbox-row', 'id' =>'hkm_checkbox'];
                }
            ],
            [
                'attribute'=>'reg_number',
                'value'=>'employee.reg_number',
                'contentOptions' => ['style' => 'max-width:10px;'],
            ],
            [
                'attribute'=>'employee_name',
                'value'=>'employee.coreperson.name',
            ],
            //'id',
            //'id_employee',
            
            //'id_component_payroll',
            'start_date',
            'end_date',            
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete} {update}',
                'buttons'=>[
                    'delete'=>function($url, $data){
                        return Html::a('Delete', ['componentpayroll/deletegroup', 'id'=>$data->id]);
                    },
                    'update'=>function($url, $data){
                        return Html::a('Update', ['componentgroup/update', 'id'=>$data->id]);
                    },
                ],
            ],
            
        ],
    ])?>
    <?php // Pjax::end();?>

</div>
<?php 
   
$urlRemove = Url::toRoute(['removegroup']);

$urlDeleteSelect = Url::toRoute(['componentpayroll/deleteselect']);
  
$js=<<<js
$('document').ready(function(){
   $('#deleteSelect').on('click', function(){ 
      var container = [];
      var selected_row = $('#grid').yiiGridView('getSelectedRows');
      $.each($("input[name='selection[]']:checked"), function() {
          container.push($(this).val());
      });  
      $.ajax({
          url : "{$urlDeleteSelect}",
          type : "POST",
          data : { 
              id:"{$model->id}",           
              item:selected_row,
          },
          success : function(result){
              console.log(result);
          }
      });
      
      alert('Anda yakin item ini : ' +selected_row);
  });
});
js;
$this->registerJs($js);
