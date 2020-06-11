<?php

use Codeception\Lib\Generator\Shared\Classname;
use kartik\select2\Select2;
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
    echo GridView::widget([
        'dataProvider'=>$provider,
        'columns'=>[
            'id',
            'emp_id',
            'value',
            //'date_insentif',           
        ],
    ]);
    
    //var_dump($data);
    
   
}
