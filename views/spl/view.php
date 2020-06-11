<?php

//use yii\bootstrap\ActiveForm;

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Spl */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Spls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="spl-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php 
        echo $model->empty==TRUE? Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'disabled' => false,
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) :
        Html::a('Delete', ['view', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'disabled' => TRUE,
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])

        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'employee.emp_name',
            'date_spl',
            'overtime_value',
            //'start_lembur',
            //'end_lembur',
            //'so',
            //'nama_pekerjaan',                        
            'employee_emp_id',
        ],
    ]) ?>

</div>
<h2> Masukkan So dan jam Lembur nya ! </h2>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model_spl_detil, 'so')->widget(Select2::className(),[
    'data'=>$list_so,
    'options' => ['placeholder' => 'Select a SO ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>
<?= $form->field($model_spl_detil, 'jam')->textInput() ?>


<div class="form-group">
        <?= Html::submitButton('+', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php Pjax::begin(['id' => 'my_pjax']); ?>
<?=GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id',
        'so',
        'jam',
        'spl_id',
        

        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{remove}',
            'buttons'=>[
                'remove' => function($url, $model) {
                   
                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delspldetil', 'id' => $model['id']], ['title' => 'Download', 'class' => '',]);
                }
            ],
        ]
    ]
   
]);?>



<?php Pjax::end(); ?>

<?php 
$this->registerJs("
$.pjax.reload({container: '#py_pjax'});

");
?>
