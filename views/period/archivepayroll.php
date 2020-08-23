<?php

use app\models\Payroll;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\i18n\Formatter;

/* @var $tdis yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
$formater = New Formatter();




?>

<?php $this->params['breadcrumbs'][] = ['label'=>'period', 'url'=>['index','id_period']];?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="archive-form">

    <?php //$form = ActiveForm::begin(); ?>

    <?php  /*= $form->field($model, 'id_payroll_group')->widget(Select2::className(),[
        'data'=>$group_list,
    ]) */?>

    

    <div class="form-group">
        <?php //= Html::submitButton('Proses', ['class' => 'btn btn-success']) ?>
        <?php 
        /*
        if (isset($model->id_payroll_group)){
            /*echo Html::a('Posting Payroll', [
                '/period/posting', 
                //'id_period'=>$period->id, 
                'id_payroll_group'=>$model->id_payroll_group], 
                ['class' => 'btn btn-success'
            ]);*/
            /*
            $payroll = Payroll::find()->where(['id_payroll_group'=>$model->id_payroll_group])->all();
            return $this->render('archivepayroll', [
                'payroll'=>$payroll,
            ]);
        }*/
    ?>
    </div>

    <?php //ActiveForm::end(); ?>
   <?=GridView::widget([
       'dataProvider'=>$provider,
       'columns'=>[
           'period.period_name',          
           'payrollGroup.name',
           [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view_payroll} #  {pdf} # {summary}',
                'buttons'=>[
                    'view_payroll' => function($url, $model) {
                        return Html::a('View Payroll', ['payrollperiod', 'id_period' => $model->id_period, 'id_payroll_group'=>$model->id_payroll_group]);
                    },
                    'pdf' => function($url, $model) {
                        return Html::a('PDF', ['payrollpdf', 'id_period' => $model->id_period, 'id_payroll_group'=>$model->id_payroll_group]);
                    },
                    'summary'=>function($url, $model){
                        return Html::a('Summary PDF',[
                            'summarypdf', 'id_period'=>$model->id_period, 'id_payroll_group'=>$model->id_payroll_group,
                        ]);
                    }
                ],
            ],
       ]
   ])?>

</div>