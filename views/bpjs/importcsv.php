<?php

use app\models\Employee;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;
use yii\grid\GridView;


?>

<?php 
$this->params['breadcrumbs'][] = ['label' => 'BPJS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo " Format : (reg_number, bpjs_kes, bpjs_tkerja)";
?>
<table class="table">    
    
    <tr>
        <th>reg_number</th>
        <th>bpks_kes</th>
        <th>bpjs_tkerja</th>
    <tr>
    <tr>
        <td>P003</td>
        <td>basic*0.2</td>
        <td>basic*0.1</td>

    </tr>
</table>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'excelFile')->fileInput() ?>
    <button>Submit</button>

<?php ActiveForm::end() ?>
<?php
if (isset($data)){
    
    $provider = New ArrayDataProvider([
        'allModels'=>$array_data,
        'pagination'=>[
            'pageSize'=>1000,
        ]
    ]);

    echo GridView::widget([
        'dataProvider'=>$provider,
    ]);
    

    
}
