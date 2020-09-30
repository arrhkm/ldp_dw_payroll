<?php

use yii\widgets\ActiveForm;
use yii\grid\GridView;
?>

<?php 

$this->title = 'Import Adjustment';
$this->params['breadcrumbs'][] = ['label' => 'Period Adjustment', 'url' => ['period-adjustment','period_id'=>$period->id]];
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'excelFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>
<?php 
if (isset($provider)){
    echo GridView::widget([
        'dataProvider'=>$provider,
        /*'columns'=>[
            'pin',
            [
                'attribute'=>'log',
                'value'=>function($data){
                    return Yii::$app->formatter->asDatetime($data['log'], 'php:Y-m-d H:i:s');
                }
            ]
        ],
        */
    ]);
}