<?php

use yii\data\ArrayDataProvider;
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

    $dataProvider = New ArrayDataProvider([
        'allModels'=>$data,
        'pagination'=>[
            'pageSize'=>1000,
        ]
    ]);
    echo GridView::widget([
        'dataProvider'=>$dataProvider,        
    ]);
    
    //print_r($data);
    
   
}
if (isset($data_kosong)){
    echo "<br> DATA KOSONG <br>";
    //print_r($data_kosong);

    $dataKosong = New ArrayDataProvider([
        'allModels'=>$data_kosong,
    ]);

    echo GridView::widget([
        'dataProvider'=>$dataKosong,
    ]);

}

if (isset($data_kosong)){
    echo "<br> DATA GAGAL SAVE <br>";
    //print_r($data_kosong);

    $dataGagal = New ArrayDataProvider([
        'allModels'=>$data_gagal_save,
        'pagination'=>[
            'pageSize'=>1000,
        ]

    ]);

    echo GridView::widget([
        'dataProvider'=>$dataGagal,
    ]);

}