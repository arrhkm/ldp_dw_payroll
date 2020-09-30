<?php

use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'Timeshifts Anggota';
$this->params['breadcrumbs'][]=  ['label' => 'Timeshift', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<table class="table">
   <th>
      <td>Timeshift </td><td>:</td><td><?=$model->name?></td>
   </th>

</table>
<p>
        <?= Html::a('+', ['add-anggota', 'id_timeshift'=>$id_timeshift], ['class' => 'btn btn-success']) ?>
</p>

<?=GridView::widget([
   
   'dataProvider'=>$dataProvider,
   'columns'=>[
      'id', 
      'employee.reg_number',
      [
         'label'=>'employee', 
         'value'=>'employee.name'
      ], 
      [
         'label'=>'Timeshift',
         'value'=>'timeshift.name',
      ],
      [
         'class'=>'yii\grid\ActionColumn',
         'template'=>'{delete}',
         'buttons'=>[
            'delete'=>function($url, $model){
               $text='delete';
               $url=['delete-timeshift', 'id'=>$model->id, 'id_timeshift'=>$model->id_timeshift];

               return Html::a($text, $url, ['calss'=>'btn btn-danger']);
            }
         ]
      ]

   ]
])?>