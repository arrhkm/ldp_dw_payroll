<?php

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PayrollGroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payroll-group-view">

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
        ],
    ]) ?>

</div>

<div class="payroll-group-employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelForm, 'id_payroll_group')->textInput() ?>   

    <?= $form->field($modelForm, 'id_employee')->widget(Select2::className(),
    [
        'data'=>$employee_list,
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
          ],
    ]) ?>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
<p><?=Html::button('Delete Selected', ['class' => 'btn btn-danger btnAllDelete'])?></p>
<?php 



echo GridView::widget([
    'dataProvider'=>$providerGroup,
    //'filterModel'=>$searchModel,
    'id'=>'grid',
    'columns'=>[
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class'=>'yii\grid\CheckboxColumn',
            'checkboxOptions'=>function($model){
                return ['value'=>$model->id];
            }
        ],
            'id',
            'id_employee',
            'employee.coreperson.name',
            'payrollGroup.name',
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{delete}',
            'buttons'=>[
                'delete' => function($url, $model) {
                    return Html::a('delete', ['deletegroupemployee', 'id' => $model['id']], ['title' => 'deletegroupemployee', 'class' => '',]);
                },
                
            ],
        ],
    ],
]);

/*if (isset($modelForm->id_employee)){
    //var_dump($modelForm->id_employee);
    foreach ($modelForm->id_employee as $dt){
        echo $modelForm->id_payroll_group." - ".$dt."<br>";
    }
}*/

$urlAllDelete = Url::to(['deleteselect']);
$js=<<<js
$('.btnAllDelete').on('click', function(){
    //var keys = $('#grid').yiiGridView('getSelectedRows');     
    var keys = $('#grid').yiiGridView('getSelectedRows');
    alert("Hello Kawan :"+keys);
    $.ajax({
        url     : "{$urlAllDelete}",
        type    : "POST", 
        data    : {item :selected_row}

    });
});


js;
$this->registerJs($js);

