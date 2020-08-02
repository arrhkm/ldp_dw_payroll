<?php

use yii\widgets\ActiveForm;
use yii\grid\GridView;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

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