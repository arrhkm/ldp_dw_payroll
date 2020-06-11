<?php
use yii\widgets\ActiveForm;
use yii\grid\GridView;
?>

<?php 
$this->params['breadcrumbs'][] = ['label' => 'Import I Resiko', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo " Fromat : (emp_id, vaue, date_indentif)";
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'excelFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>
<?php
if (isset($data)){
    /*echo GridView::widget([
        'dataProvider'=>$provider,
        'columns'=>[
            'id',
            'pin',
            'date_log',
            'id_attmachine',
            'status', 
            'verified',
        ],
    ]);*/
    
    var_dump($data);
    
   
}