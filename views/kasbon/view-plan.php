<?php

use kartik\grid\GridView;
use yii\bootstrap\Html;

$this->title = 'Detil Plan Kasbon: ';
$this->params['breadcrumbs'][] = ['label' => 'Kasbons', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Kasbon Plan';
?>

<h1><?= Html::encode($this->title) ?></h1>


<table class="table">
   <tr>
      <th>Kasbon</th><td>:</td><td><?=Yii::$app->formatter->asCurrency($kasbon->nilai_kasbon, '')?></td>
   </tr>
   <tr>
      <th>Person</th><td>:</td><td><?=$kasbon->employee->coreperson->name?></td>
   </tr>
   <tr>
      <th>Tanggal kasbon</th><td>:</td><td><?=$kasbon->date_kasbon?></td>
   </tr>
</table>
<div>
   <p>Detil Plan</p>
   <hr>
</div>
<p>
   <?= Html::a('+', ['create-plan', 'id' => $kasbon->id], ['class' => 'btn btn-success']) ?>
</p>

<?=GridView::widget([
   'dataProvider'=>$dataProvider,
   'columns'=>[
      'id_kasbon',
      'date_kasbon_plan',
      [
         'attribute'=>'plan_value',
         'format'=>'currency',
      ],
      'is-close',
      [
         'class'=>'yii\grid\ActionColumn',
         'template'=>'{update} {delete}',
         'buttons'=>[
            'update'=>function($url, $model){
               return Html::a('update', ['update-plan', 'id_kasbon'=>$model->id_kasbon, 'id'=>$model->id], ['class'=>'btn btn-primary']);
            },
            'delete'=>function($url, $model){
               return Html::a('delete', ['delete-plan', 'id_kasbon'=>$model->id_kasbon, 'id'=>$model->id], ['class'=>'btn btn-danger']);
            }
         ]
      ]
   ]

])?>